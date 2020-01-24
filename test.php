<?php
$maxProblem= 20;

$baseProblemOldFilePath = __DIR__.'\test_base_csv\test_base.csv';
$baseProblemNewFilePath = __DIR__.'\test_base_csv\test_base_new.csv';
$baseProblemLineCount = 0;
$testPath = __DIR__.'\test_txt\\';
$testFileName = 'test';
createProblem($baseProblemOldFilePath, $testPath, $testFileName.'_old_', $maxProblem);
createProblem($baseProblemOldFilePath, $testPath, $testFileName.'_new_', $maxProblem);

function createProblem($problemBaseFilePath, $testDirPath, $testFileName, $maxProblem){
    if (PHP_OS == 'WIN32' || PHP_OS == 'WINNT') {
        $baseProblemLineCount = count(file($problemBaseFilePath));
    } else {
        $baseProblemLineCount = exec( 'wc -l '.$problemBaseFilePath );
    }

    if ($maxProblem > $baseProblemLineCount) {
        $maxProblem = $baseProblemLineCount;
    }

    $problemRandLineList = [];
    while (count(array_keys($problemRandLineList)) < $maxProblem) {
        $problemRandLineList[rand(1, $baseProblemLineCount)] = true;
    }

    $problemFile = fopen($testDirPath.$testFileName.date('Y-M-D').'.txt', 'w+');
    foreach (fetchProblem($problemBaseFilePath, $problemRandLineList) as $englishProblem) {
        var_dump($englishProblem);
        fwrite($problemFile, $englishProblem);
    }
}

function fetchProblem($filePath, $problemRandLineList)
{
    $lineNo = 0;
    $problemNo = 0;
    if (is_dir($filePath) === false && file_exists($filePath)) {
        $fp = fopen($filePath, "rb");
        while (($line = fgets($fp)) !== false) {
            $lineNo++;
            echo $lineNo;
            if (key_exists($lineNo, $problemRandLineList) === false) {
                continue;
            }
            $problemNo++;
            yield "$problemNo ) $line : \n";
        }
    }

    fclose($fp);

}