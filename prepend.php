<?php
require_once __DIR__ . '/vendor/autoload.php';

use SebastianBergmann\CodeCoverage\Filter;
use SebastianBergmann\CodeCoverage\CodeCoverage;
use SebastianBergmann\CodeCoverage\Driver\Xdebug;

$filter = new Filter();
// 添加文件夹白名单，一般设为应用的业务代码目录，不设置则统计所有文件
$filter->addDirectoryToWhitelist('/data0/www/htdocs/code/application');
$filter->removeDirectoryFromWhitelist('/data0/www/htdocs/code/application/controllers/Console');
// 初始化覆盖率工具
$coverage = new CodeCoverage(new Xdebug(), $filter);
// 开始统计
$coverage->start('Decoration coverage');
// 注册处理函数
register_shutdown_function(function (CodeCoverage $coverage) {
    $coverage->stop();
    $savePath = __DIR__ . '/report';
    $cov = '<?php return unserialize(' . var_export(serialize($coverage), true) . ');';
    file_put_contents($savePath . '/' . date('Y-m-d-H') . '.' . uniqid() . '.cov', $cov);
}, $coverage);
