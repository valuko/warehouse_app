<?php

namespace app\commands;

use Yii;
use tebazil\yii2seeder\Seeder;
use yii\console\Controller;

class SeedController extends Controller
{
    public function actionIndex()
    {
        //return $this->render('index');
        $seeder = new Seeder();
        $generator = $seeder->getGeneratorConfigurator();
        $faker = $generator->getFakerConfigurator();

        $seeder->table('employee')->columns([
            'id', //automatic pk
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'username' => $faker->userName,
            'password' => Yii::$app->getSecurity()->generatePasswordHash('123456'),
        ])->rowQuantity(5);

        $seeder->table('category')->columns([
            'id',
            'name' => $faker->word,
        ])->rowQuantity(5);

        $seeder->refill();

        return 0;
    }

}
