<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/22
 * Time: 17:08
 */
$lee=function($str){
    echo $str;
};
//$lee("lee");


/*2*/
function test($name){
    $name = $name;
    $age = 1;
    $func = function() use($name,&$age){
        echo "姓名：".$name."年龄：".$age;
        ++$age;


    };
    $func();
    echo  $age;
}

 test("lee");

?>
<script>

    var lee = 1;
    function test(){
        var lee =2;
        function aa() {
            function as(){
                console.log(lee);
            }

        }
        return aa();
    }
    test();
//    var name = "The Window";
//    var object = {
//        name : "My Object",
//        getNameFunc : function(){
//            var that = this;
//            console.log(that);
//            return function(){
//                return that.name;
//            };
//        }
//    };

    var name = "The Window";
    alert(name);
    var object = {
        name : "My Object",
        getNameFunc : function(name){
                console.log(this.name);
                console.log(name);
        }
    };
    console.log(object.getNameFunc());
//
//    alert(object.getNameFunc()());
</script>
