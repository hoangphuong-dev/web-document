<?php

namespace App\Livewire\Document;

use App\Enums\Document\EagerLoadScene;
use App\Jobs\Document\ActionLoadPageDetail;
use App\Models\Document;
use Livewire\Component;
use Livewire\Attributes\On;

class EagerLoadDocumentDetail extends Component
{
    public string $urlPreview;
    public Document $document;
    public string $type;

    #[On('eagerLoad')]
    public function eagerLoad()
    {
        ActionLoadPageDetail::dispatch($this->document);
        if ($this->type == EagerLoadScene::PREVIEW) {
            $this->urlPreview = $this->document->urlPreviewDocument();
        }
    }

    public function render()
    {
        return view('livewire.document.eager-load-document-detail');
    }
}
