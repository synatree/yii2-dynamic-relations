Dynamic Relations Extension
===========================

This extension came about after I googled in vain for such things as:

- Create 'child' models from a 'master' view dynamically
- Add Inputs to Yii2 views dynamically
- Use Yii2 widgets in related models
- Add fields to a form dynamically

Hopefully the above saves somebody else some time searching.

What does this do?
------------------
Sometimes a picture is worth 1000 words:
![Screenshot of Basic Functionality](http://synatree.com/assets/persist/yii2-dynamic-relations-example.png "Screenshot of Basic Functionality")

Allows Yii2 views to contain a dynamically expanding set of fields based on model relations.

This system allows you to define a view, conventionally called _inline.php, that will be auto-loaded each time a user hits the "add" button on your form.

Behind the scenes, the module takes care of saving the related records if they are new, updating them if they have been changed, and removing them if deleted.

Basically this is a way to add an arbitrarily expanding set of related records to your model using Ajax.

It's also been designed to intellegently move the JavaScripts and event bindings that your view's widgets may use so as not to conflict with each other when multiple "identical" views are added via ajax.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require synatree/yii2-dynamic-relations "dev-master"
```

or add

```
"synatree/yii2-dynamic-relations": "dev-master"
```

to the require section of your `composer.json` file.

Next, you must add the following to your module config:

```php
    'modules' => [
    ...
		'dynamicrelations' => [
			'class' => '\synatree\dynamicrelations\Module'
		],
    ...
```


Usage
-----

The first thing you should do is to create a view called _inline.php for the model you which to use dynamically.  This view can include arbitrary widgets, it's been tested with some widgets from Krajee.

This is the most complicated part, because we have to ensure that every time this view is invoked, the HTML and the script generated are unique. 

You'll also have to tell DynamicRelations how to add and remove models by providing routes.

Finally, you'll have to maintain a certain structure in your field names so that the widget can pick up new vs existing models upon submit.  Example:


```php
use synatree\dynamicrelations\DynamicRelations;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\BusinessHours */
/* @var $form kartik\widgets\ActiveForm */

// generate something globally unique.
$uniq = uniqid();

if( $model->primaryKey )
{
    // you must define an attribute called "data-dynamic-relation-remove-route" if you plan to allow inline deletion of models from the form.

	$removeAttr = 'data-dynamic-relation-remove-route="' . 
		Url::toRoute(['business-hours/delete', 'id'=>$model->primaryKey]) . '"';
	$frag = "BusinessHours[{$model->primaryKey}]";
}
else
{
    $removeAttr = "";
    // new models must go under a key called "[new]"
    $frag = "BusinessHours[new][$uniq]";
}

?>
<div class="BusinessHours-form form-inline" <?= $removeAttr; ?>>

    <?= DateControl::widget([
			'type' => DateControl::FORMAT_DATE,
			'name' => $frag.'[day]', // expanded, this ends up being something like BusinessHours[1][day] or BusinessHours[new][random][day]
			'value' => $model->day,
			// for Kartik widgets, include the following line.  This basically generates a globally unique set of pluginOptions, which is important to prevent
			// javascript errors and make sure everything works as expected.
			'options' => DynamicRelations::uniqueOptions('day',$uniq)
    ]);?>
    .... More widgets use the same structure as above .... 
</div>
```
The next step is to setup the controller to save the related models you're expecting to receive.  In the below example, we only have to add one small line to each of the create and update action methods.

```php
use synatree\dynamicrelations\DynamicRelations;
use app\models\BusinessHours;
use yii\web\Controller;

class SomeController extends Controller
{
    /**
	 * Creates a new SomethingModel model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
    */

    public function actionCreate()
    {
        $model = new SomethingModel();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
				// this next line is the only one added to a standard Gii-created controller action:
                DynamicRelations::relate($model, 'hours', Yii::$app->request->post(), 'BusinessHours', BusinessHours::className());
                //           Parent Model --^       ^-- Attribute    ^-- Array to search  ^-- Root Key  ^-- Model Class Name
                return $this->redirect(['view', 'id' => $model->primaryKey]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
    }

    public function actionUpdate($id)
    {
        ...
        if ($model->save()) {
            // this next line exactly the same as in actionCreate:
            DynamicRelations::relate($model, 'hours', Yii::$app->request->post(), 'BusinessHours', BusinessHours::className());
            return $this->redirect(['view', 'id' => $model->boatShowId]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        ...
    }
}
```
Finally, in your view for the parent model, include lines like the following for each related model you want to add dynamically.

```php
use synatree\dynamicrelations\DynamicRelations;
<?= DynamicRelations::widget([
	'title' => 'Business Hours',
	'collection' => $model->hours,
	'viewPath' => '@app/views/business-hours/_inline.php'
]); ?>
```
That should do it.  I hope this helps people, I really wanted this feature.
