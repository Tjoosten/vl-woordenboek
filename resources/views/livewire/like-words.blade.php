<div>
    @auth
        <div class="float-start">
            @if (! auth()->user()->hasLiked($word))
                <button wire:click="likeWord" class="btn btn-sm btn-outline-success">
                    <x-heroicon-s-hand-thumb-up class="icon me-1"/> Upvote
                </button>
            @elseif (auth()->user()->hasLiked($word))
                <button wire:click="dislikeWord" class="btn btn-sm btn-outline-danger">
                    <x-heroicon-o-hand-thumb-down class="icon me-1"/> Downvote
                </button>
            @endif
        </div>
    @endauth

    <div class="float-end">
        <ul class="list-inline mb-0">
            <li class="list-inline-item text-muted">
                <x-heroicon-s-hand-thumb-up class="icon text-success me-1"/>
                Upvotes: <span class="fw-bold">{{ $upvotes }}</span>
            </li>
        </ul>
    </div>
</div>
