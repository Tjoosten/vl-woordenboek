<?php

declare(strict_types=1);

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use App\Filament\Resources\ArticleResource\Schema\FormSchema;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\CreateRecord\Concerns\HasWizard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

final class CreateWord extends CreateRecord
{
    use HasWizard;

    protected static string $resource = ArticleResource::class;

    public function form(Form $form): Form
    {
        return parent::form($form)
            ->schema([
                Wizard::make($this->getSteps())
                    ->startOnStep($this->getStartStep())
                    ->cancelAction($this->getCancelFormAction())
                    ->submitAction($this->getSubmitFormAction())
                    ->skippable($this->hasSkippableSteps())
                    ->contained(false)
            ])->columns(null);
    }

    /**
     * @return array<int, Wizard\Step>
     */
    protected function getSteps(): array
    {
        return [
            Wizard\Step::make(trans('Algemene informatie'))
                ->icon('heroicon-o-language')
                ->columns(12)
                ->schema([FormSchema::sectionConfiguration()->schema(FormSchema::getDetailSchema())]),
            Wizard\Step::make(trans('Regio & status'))
                ->icon('heroicon-o-map')
                ->columns(12)
                ->schema([FormSchema::sectionConfiguration()->schema(FormSchema::getStatusAndRegionDetails())]),
        ];
    }
}
