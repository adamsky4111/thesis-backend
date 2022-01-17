<?php

namespace App\Service\Viewer\Handler\Action;

use App\Service\Viewer\ConnectionSocketElement;
use App\Service\Viewer\Handler\EventContext;

final class HandleStreamChunkAction extends AbstractAction implements ConnectionEventActionInterface
{
    protected string $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    function action(EventContext $context): void
    {
        // $dir = $this->projectDir.'/data/'.$context->getElement()->getStreamId();
        // $chunkNumber = (int) file_get_contents($dir . '/info');
        // file_put_contents($dir . '/' . ++$chunkNumber, $context->getData()['file']);
        // file_put_contents($dir . '/info', $chunkNumber);
        // $data = file_get_contents($dir . '/' . $chunkNumber);
        /** @var ConnectionSocketElement $element */
        foreach ($context->getData()['viewers'] as $element) {
            $element->getConnection()->send($this->createResponse(['chunk' => $context->getData()['file']]));
        }
    }

    function getEventName(): string
    {
        return 'chunk';
    }
}