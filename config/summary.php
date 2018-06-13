<?php
/**
 * Created by PhpStorm.
 * User: conghoan
 * Date: 24/08/2017
 * Time: 10:30
 */

return [
    'vi' => [
        'end_document_regex' => '/DANH MỤC|PHỤ LỤC|THAM KHẢO/u',
        'alt_regex' => '/^(biểu đồ|hình|ảnh|bảng)\s+\w+/ui',
        'strim_alt_regex' => '/\'/^(biểu đồ|hình|ảnh)\s+[^\s]+\s+/ui\'',
        'not_heading' => '/(mục lục|danh mục)/ui',
        'caption_regex' => '/^(bảng|hình|biểu đồ|ảnh)\s+([0-9]){1,2}(\.([0-9]){1,2}){1,3}\.?(?<!\)) /ui',
        'heading_regex' => '/^(Chương|Phần|Bài)/ui',
        'heading_sign_regex' => '/^(Chương|Phần|Bài)\s+[IVX0-9]{1,2}\s*(\:|\.)?\s*/ui',
        'first_upper_regex' => '/^(Chương|CHƯƠNG|PHẦN|Phần|Bài|BÀI)([^a-záàãảạăắằẵẳặâấầẫảạđéèẻẽẹêểếềệễíìĩỉịôốổồỗộơớờởỡợóòỏõọuúùũủụưứừửựữýỳỷỹỵ])*$/u',
    ],
    'id' => [
        'end_document_regex' => '/KATEGORY|LAMPIRAN|REFERENSI/u',
        'alt_regex' => '/^(PENGESAHAN|bagan|Figur|foto|tabel|Gambar)\s+\w+/ui',
        'strim_alt_regex' => '/\'/^(PENGESAHAN|bagan|Figur|foto|tabel|Gambar)\s+[^\s]+\s+/ui\'',
        'not_heading' => '/(daftar isi|kategori)/ui',
        'caption_regex' => '/^( PENGESAHAN|tabel|bagan|Gambar|Figur|foto)\s+([0-9]){1,2}(\.([0-9]){1,2}){1,3}\.?(?<!\)) /ui',
        'heading_regex' => '/^(Paragraf|Pasal|Bab|Bagian|Pelajaran)/ui',
        'heading_sign_regex' => '/^(Paragraf|Pasal|Bab|Bagian|Pelajaran)\s+[IVX0-9]{1,2}\s*(\:|\.)?\s*/ui',
        'first_upper_regex' => '/^(Paragraf|Paragrag|Pasal|PASAL|Bab|Bagian|Pelajaran|BAB|BAGIAN|PELAJARAN)([^a-záàãảạăắằẵẳặâấầẫảạđéèẻẽẹêểếềệễíìĩỉịôốổồỗộơớờởỡợóòỏõọuúùũủụưứừửựữýỳỷỹỵ])*$/u',
    ],
    'document' => [
        'type' => [
            'short' => [
                'min_page' => 10,
                'min_char' => 50000
            ],
            'test' =>[
                'rate_line' => 2,
                'rate_page' => 0.7
            ],
            'curriculum' => [
                'rate_math' => 5,
                'rate_page' => 0.7,
                'min_rate_page' => 0.9
            ],
            'slide' => [
                'rate_slide' => 0.5
            ],
            'fake_print' => [
                'rate_consonant' => 0.6
            ]
        ],
        'extras' => [
            'max_header_height' => 120,
            'max_count' => 6
        ],
        'summary' => [
            'max_depth' => 3,
            'min_paragraph' => 2
        ]
    ],
    'page' => [
        'table_content' => [
            'min_rate' => 0.6,
            'min_count' => 4
        ],
        'heading_table' => [
            'differ' => 70,
            'heading_rate' => 0.6,
            'heading_count' => 5,
            'min_count' => 7
        ],
        'abstract' => [
          'rate' => 0.7,
          'count' => 3
        ],
        'max_main_font' => 5,
        'max_start_deny' => 11,
        'end' => 0.2,
        'extra_end' => 0.3
    ],
    'line' => [
        'height' => 50
    ],
];