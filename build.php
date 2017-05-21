<?php
/**
 * 包打包文件脚本。
 *
 * @author     邢柳 <julyxing@163.com>
 * @copyright  © 2017 JulyXing
 * @license    GPL-3.0 +
 */

header("Content-Type:text/html;charset=utf-8");

$exts = ['php', 'twig'];

$dir = __DIR__;

$file = 'test.phar';

$phar = new Phar(__DIR__ . '/' . $file, FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME, $file);

$phar->startBuffering();

foreach ($exts as $ext) {
    $phar->buildFromDirectory($dir, '/\.' . $ext . '$/');
}

$phar->delete('build.php');

// 应用入口设置
$phar->setStub("
<?php
    Phar::mapPhar('{$file}');
    require 'phar://{$file}/index.php';
    __HALT_COMPILER();
?>");

$phar->stopBuffering();

echo "应用 {$file} 打包结束";
