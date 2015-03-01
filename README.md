# yii2-closest-relation-trait
This trait adds capability to fetch nearest related model class without need of redefininf relations on extensions.

Why?
==============
I like using `gii` however if you have frequently changed table like me then it is a pain to continue using `gii` or adding changes by hand.

And if you are using `yii2` with more than one app you have to move relations as you extend models.

This trait (yes I have used trait instead of behaviours) add capability to call nearest Class sharing namespace of the model and its parents.

For example, let's say we are using `yii2-advance-template` so we may have 3 or more childs of same class.

call the class `Page` and relation to `Author`

you probably has it in `common\models`, `frontend\models` and `backend\models` so if you don't override the relations you probably get `common\models\Author` with getter. It is easy to copy and paste relations however adding a trait to your base model is easier. 


How to use?
==============
##Installation with Composer
Just add the line under `require` object in your `composer.json` file.
``` json
{
  "require": {
    "udokmeci/yii2-beanstalk" : "dev-master"
  }
}
```
then run 

``` console
$> composer update
```


##Add trait to your base model. 
###Via Model Generator
Add following `generators` array to your configuration file.
```php
$config['modules']['gii'] = [
    'class' => 'yii\gii\Module',
    'generators' => [
        'model'=>'udokmeci\yii2closestrelation\model\Generator'
    ],
    'allowedIPs' => ['*'],
];
```
###Manual
Just add `use` statement in class and pass the all relation `className` params from `static::getRelationName()` method.
Example below:

```php
<?php

namespace common\models\base;

use Yii;

class Page extends \yii\db\ActiveRecord
{
	//here is the trait and see also the relation
	use \udokmeci\yii2closestrelation\ClosestRelationTrait

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(static::getRelationName(Author::className()), ['author_id' => 'id']);
    }
}



```

Now if you have both `\frontend\models\Page` and `\frontend\models\Author` relation returns `\frontend\models\Author` if you dont have both then `\common\models\base\Author` is returned again.

Enjoy it.


