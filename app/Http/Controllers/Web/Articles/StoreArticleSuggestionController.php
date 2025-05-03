<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Articles;

use App\Actions\Articles\StoreArticleSuggestion;
use App\Http\Requests\Articles\StoreSuggestionRequest;
use App\Models\PartOfSpeech;
use App\Models\Region;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\RateLimiter;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;

/**
 * StoreArticleSuggestionController manages the creation of new dictionairy article suggestion entries.
 *
 * This controller handles both the display of the submîssion form and the processing of new article submissions.
 * It integrates the attribute-based routing system for clean route definitions.
 * The workflow supports a streamlines proces for contributring new words to the Vlaams Woordenboek
 *
 * @package App\Http\Controllers\Web\Articles
 */
final readonly class StoreArticleSuggestionController
{
    /**
     * Displays the article submission form.
     *
     * Prepares the creation view by loading all available regions and parts of speech for dropdown selection.
     * The regions and parts of speech are provided in a format suitable for form select elements, with their names as labels and IDs as values.
     *
     * @return Renderable The form view for creating new dictionary entries.
     */
    #[Get(uri: 'woordenboek-artikelen/insturen', name: 'definitions.create')]
    public function create(): Renderable
    {
        return view('definitions.create', [
            'regions' => Region::query()->pluck('name', 'id'),
            'partOfSpeeches' => PartOfSpeech::query()->pluck('name', 'id'),
        ]);
    }

    /**
     * Processes the submission of a new dictionary entry.
     *
     * Handles the POST request containing the new article data.
     * After validation through the form request, it delegates the storage operation to a dedicated action class.
     * Upon successful creation, redirects to the search interface where users can find their newly submitted entry.
     *
     * @param  StoreSuggestionRequest $storeSuggestionRequest   The form request that validates the request data?
     * @param  StoreArticleSuggestion $storeArticleSuggestion   The action that uis responsible for storing the dictionary article.
     * @return RedirectResponse                                 Redirects to search interface after submission.
     */
    #[Post(uri: 'woordenboek-artikelen/insturen', name: 'definitions.store')]
    public function store(StoreSuggestionRequest $storeSuggestionRequest, StoreArticleSuggestion $storeArticleSuggestion): RedirectResponse
    {
        if (RateLimiter::tooManyAttempts('submission:' . $storeSuggestionRequest->ip(), maxAttempts: 15)) {
            flash('Het lijkt erop dat je te veel suggesties probeerd toe te voegen op een te korte tijd. Probeer het later nog eens', 'alert-danger');
            return back();
        }

        RateLimiter::increment('submission:' . $storeSuggestionRequest->ip(), amount: 1);

        $storeArticleSuggestion->execute($storeSuggestionRequest->getData());

        return redirect()->action(SearchController::class);
    }
}
