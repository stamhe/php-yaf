--TEST--
Check for Yaf_Loader
--SKIPIF--
<?php if (!extension_loaded("yaf")) print "skip"; ?>
--INI--
yaf.use_spl_autoload=0
yaf.lowcase_path=0
--FILE--
<?php 
ini_set("ap.lowcase_path", FALSE);
$loader = Yaf_Loader::getInstance(dirname(__FILE__), dirname(__FILE__) . "/global");
$loader->registerLocalNamespace("Baidu");
$loader->registerLocalNamespace("Sina");
$loader->registerLocalNamespace(array("Wb", "Inf", NULL, array(), "123"));
var_dump($loader->getLocalNamespace());
var_dump($loader->isLocalName("Baidu_Name"));

try {
	var_dump($loader->autoload("Baidu_Name"));
} catch (Yaf_Exception_LoadFailed $e) {
	var_dump($e->getMessage());
} 
try {
	var_dump($loader->autoload("Global_Name"));
} catch (Yaf_Exception_LoadFailed $e) {
	var_dump($e->getMessage());
} 

?>
--EXPECTF--
string(21) "Baidu:Sina:Wb:Inf:123"
bool(true)

Warning: Yaf_Loader::autoload(): Failed opening script %s/Baidu/Name.php: %s in %s
bool(true)

Warning: Yaf_Loader::autoload(): Failed opening script %s/global/Global/Name.php: %s in %s
bool(true)
