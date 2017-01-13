<?php
/***
 *
 *                        ,%%%%%%%%,
 *                      ,%%/\%%%%/\%%
 *                     ,%%%\c "" J/%%%
 *            %.       %%%%/ o  o \%%%
 *            `%%.     %%%%    _  |%%%
 *             `%%     `%%%%(__Y__)%%'
 *             //       ;%%%%`\-/%%%'
 *            ((       /  `%%%%%%%'
 *             \\    .'          |
 *              \\  /       \  | |
 *               \\/         ) | |
 *                \         /_ | |__
 *                (___________))))))) 攻城狮
 *
 * @author：gaoyuan
 * @created_time：2017/1/12 15:53
 * When I wrote this, only God and I understood what I was doing
 * Now, God only knows
 */

namespace app\index\controller;


use think\Controller;

class Test extends Controller
{
    public  function  index(){



        dump(cookie('user1'));
        dump(cookie('user2'));
        dump(cookie('user3'));
        dump(cookie('user4'));

        $result=cookie('user4');


        dump(json_decode($result,true));


        return $this->fetch();
    }

}