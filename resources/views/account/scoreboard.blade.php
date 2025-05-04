@extends('layouts.application-blank', ['title' => __('Mijn scorebord')])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <x-account.profile-information-banner :user=$user/>
            </div>
        </div>

        @if ($user->getPoints() > 0)
            <div class="row pt-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header color-green bg-white">
                            Mijn level progressie <br>
                        </div>
                        <div class="card-body">
                            <div class="progress" role="progressbar" aria-label="Progressie tot het volgende level" aria-valuenow="{{ $user->getPoints() }}" aria-valuemin="0" aria-valuemax="9000" style="height: 20px">
                                <div class="progress-bar" style="width: {{ $user->getPoints() / 9000 * 100 }}%">{{ $user->getPoints() }}/9000 EXP</div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-4 text-start">
                                    <span class="text-muted">Huidig level:</span>
                                    <span class="fw-bold color-green">{{ $user->getLevel() }}</span>
                                </div>
                                <div class="col-4 text-center">
                                    <span class="text-muted">Benodige EXP:</span>
                                    <span class="fw-bold color-green"> {{ $user->nextLevelAt() }}</span>
                                </div>
                                <div class="col-4 text-end">
                                    <span class="text-muted">Volgend level:</span>
                                    <span class="fw-bold color-green">{{ $user->getLevel() + 1 }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-sidenav border-0">
                        <div class="mb-3">
                            <h5 class="color-green mb-0">Scoreboard gegevens</h5>
                            <p class="text-muted fst-italic">Geef nu toe wil wil er nu niet winnen in ons Vlaams Kampioenschap der contributies. Een speekmedialle is de hoofdprijs en de eeuwige roem.</p>
                        </div>
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="example-tab" data-bs-toggle="tab" data-bs-target="#example-tab-pane" type="button" role="tab" aria-controls="example-tab-pane" aria-selected="true">
                                    Scorebord
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="region-tab" data-bs-toggle="tab" data-bs-target="#region-tab-pane" type="button" role="tab" aria-controls="region-tab-pane" aria-selected="true">
                                    Mijn achievements
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="label-tab" data-bs-toggle="tab" data-bs-target="#label-tab-pane" type="button" role="tab" aria-controls="label-tab-pane" aria-selected="true">
                                    Mijn score historiek
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="label-tab" data-bs-toggle="tab" data-bs-target="#label-tab-pane" type="button" role="tab" aria-controls="label-tab-pane" aria-selected="true">
                                    Spelregels
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="example-tab-pane" role="tabpanel" aria-labelledby="example-tab" tabindex="0">

                            </div>

                            <div class="tab-pane fade show" id="region-tab-pane" role="tabpanel" aria-labelledby="region-tab" tabindex="0">

                            </div>

                            <div class="tab-pane fade show" id="label-tab-pane" role="tabpanel" aria-labelledby="label-tab" tabindex="0">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
