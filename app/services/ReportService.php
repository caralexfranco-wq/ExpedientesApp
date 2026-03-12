<?php

declare(strict_types=1);

namespace App\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory as WordWriter;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory as PptWriter;

class ReportService
{
    public function exportExcel(array $rows, string $filename): string
    {
        $sheet = (new Spreadsheet())->getActiveSheet();
        $sheet->fromArray(array_keys($rows[0] ?? []), null, 'A1');
        $sheet->fromArray($rows, null, 'A2');
        $path = base_path('storage/exports/' . $filename . '.xlsx');
        (new Xlsx($sheet->getParent()))->save($path);
        return $path;
    }

    public function exportWord(array $rows, string $filename): string
    {
        $doc = new PhpWord();
        $section = $doc->addSection();
        $section->addText('Reporte de Expedientes');
        foreach ($rows as $row) {
            $section->addText(implode(' | ', array_map(static fn($v) => (string)$v, $row)));
        }
        $path = base_path('storage/exports/' . $filename . '.docx');
        WordWriter::createWriter($doc, 'Word2007')->save($path);
        return $path;
    }

    public function exportPowerPoint(array $rows, string $filename): string
    {
        $ppt = new PhpPresentation();
        $slide = $ppt->getActiveSlide();
        $shape = $slide->createRichTextShape()->setHeight(500)->setWidth(900);
        $shape->createTextRun('Reporte Ejecutivo de Expedientes');
        foreach ($rows as $row) {
            $shape->createBreak();
            $shape->createTextRun(implode(' | ', array_map(static fn($v) => (string)$v, $row)));
        }
        $path = base_path('storage/exports/' . $filename . '.pptx');
        PptWriter::createWriter($ppt, 'PowerPoint2007')->save($path);
        return $path;
    }
}
