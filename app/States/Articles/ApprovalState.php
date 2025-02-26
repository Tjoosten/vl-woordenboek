<?php

declare(strict_types=1);

namespace App\States\Articles;

use App\Enums\ArticleStates;

/**
 * ApprovalState represents an article awaiting editorial review in the Vlaams Woordenboek.
 *
 * This state indicates that the article has been submitted for review and requires editorial approval before publication.
 * The state provides multiple transition paths to support various editorial decisions: returning to draft for further editing, approving for publication, or archiving if deemed unsuitable.
 *
 * @package App\States\Articles
 */
final class ApprovalState extends ArticleState
{
    /**
     * Returns the article to draft status for additional editing.
     *
     * This transition is typically used when the reviewing editor determines that the article needs further refinement before it can be published.
     * The article returns to a draft state where authors can make the requested changes.
     */
    public function transitionToEditing(): void
    {
        $this->article->update(attributes: ['state' => ArticleStates::Draft]);
    }

    /**
     * Approves the article and transitions it to published status.
     *
     * This transition occurs when an editor determines the article meets all quality standards and is ready for public viewing.
     * The article becomes visible to all users once published.
     */
    public function transitionToReleased(): void
    {
        $this->article->update(attributes: ['state' => ArticleStates::Published]);
    }

    /**
     * Archives the article, removing it from the active review process.
     *
     * This transition is used when an editor decides the article should not be published but should be retained for reference.
     * Archived articles can be restored later if circumstances change.
     */
    public function transitionToArchived(): void
    {
        $this->article->update(attributes: ['state' => ArticleStates::Archived]);
    }
}
