<?php

namespace app\tests\api;

use app\tests\fixtures\CommentFixture;
use app\tests\fixtures\FileFixture;
use app\tests\fixtures\UserFixture;
use Yii;

class ApiCest
{
    public function _fixtures(){
        return [
            'comments' => CommentFixture::className(),
            'files' => FileFixture::className(),
            'users' => UserFixture::className()
        ];
    }

    public function testGetUserJson(\ApiTester $I){
        $I->sendGET('/user',['_format'=>'json']);
        $I->canSeeResponseIsJson();
    }

    public function testGetUserXml(\ApiTester $I){
        $I->sendGET('/user',['_format'=>'xml']);
        $I->canSeeResponseIsXml();
    }

    public function testGetFileJson(\ApiTester $I){
        $I->sendGET('/file',['_format'=>'json']);
        $I->canSeeResponseIsJson();
    }

    public function testGetFileXml(\ApiTester $I){
        $I->sendGET('/file',['_format'=>'xml']);
        $I->canSeeResponseIsXml();
    }

    public function testGetCommentJson(\ApiTester $I){
        $I->sendGET('/comment',['_format'=>'json']);
        $I->canSeeResponseIsJson();
    }

    public function testGetCommentXml(\ApiTester $I){
        $I->sendGET('/comment',['_format'=>'xml']);
        $I->canSeeResponseIsXml();
    }

    /*
    public function testPostIsNotWorked(\ApiTester $I){
        $I->sendPOST('/user');
        //он не может создать что-либо через пост, потому что Get не показывает пароли
        $I->canSeeResponseCodeIsServerError();
    }*/

    public function testDeleteIsNotWorked(\ApiTester $I){
        $I->sendDELETE('/user',['id'=>'1']);
        //method not allowed
        $I->seeResponseCodeIs(405);
    }

    public function testUpdateIsNotWorked(\ApiTester $I){
        $I->sendPUT('/user',['id'=>'1']);
        //method not allowed
        $I->seeResponseCodeIs(405);
    }
}