<?php
namespace App\Service;

// OLD CONVERTER 
use League\CommonMark\CommonMarkConverter;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\MarkdownConverter;

class MarkdownRenderer {
    private MarkdownConverter $converter;

    public function __construct() { 

        // Define your configuration, if needed
        $config = [
            'table' => [
                'wrap' => [
                    'enabled' => false,
                    'tag' => 'div',
                    'attributes' => [],
                ],
                'alignment_attributes' => [
                    'left'   => ['align' => 'left'],
                    'center' => ['align' => 'center'],
                    'right'  => ['align' => 'right'],
                ],
            ],
        ];

        // Configure the Environment with all the CommonMark parsers/renderers
        $environment = new Environment($config);
        $environment->addExtension(new CommonMarkCoreExtension());

        // Add this extension
        $environment->addExtension(new TableExtension());

        // Instantiate the converter engine and start converting some Markdown!
        $this->converter = new MarkdownConverter($environment);

        /*
        $this->converter = new CommonMarkConverter([
            'html_input' => 'allow',
            'allow_unsafe_links' => true
        ]);
        */    
    }

    public function render(string $markdown): string {
        // Change ->getContent() to (string) casting, which works across all versions
        return (string) $this->converter->convert($markdown);
    }
}
