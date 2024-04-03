@php use App\Models\Transport; @endphp
@php
    /** @var \App\Models\Lot $lot */
@endphp

<div class="describe-content">
    <div class="faq-wrap wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Автотранспорт маълумотлари
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                     data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <ul class="describe-list">
                            <li>
                                <b>{{ Transport::label('name') }}:</b>
                                <span>{{ $lot->lotable->name }}</span>
                            </li>
                            <li>
                                <b>{{ Transport::label('car_number') }}:</b>
                                <span>{{ $lot->lotable->car_number }}</span>
                            </li>
                            <li>
                                <b>{{ Transport::label('year_of_issue') }}:</b>
                                <span>{{ $lot->lotable->year_of_issue }}</span>
                            </li>
                            <li>
                                <b>{{ Transport::label('color') }}:</b>
                                <span>{{ $lot->lotable->color }}</span>
                            </li>
                            <li>
                                <b>{{ Transport::label('technical_condition') }}:</b>
                                <span>{{ $lot->lotable->technical_condition }}</span>
                            </li>
                            <li>
                                <b>{{ Transport::label('model') }}:</b>
                                <span>{{ $lot->lotable->model }}</span>
                            </li>

                            <li>
                                <b>{{ Transport::label('body_number') }}:</b>
                                <span>{{ $lot->lotable->body_number }}</span>
                            </li>
                            <li>
                                <b>{{ Transport::label('curb_weight') }}:</b>
                                <span>{{ $lot->lotable->curb_weight }}</span>
                            </li>
                            <li>
                                <b>{{ Transport::label('unladen_weight') }}:</b>
                                <span>{{ $lot->lotable->unladen_weight }}</span>
                            </li>
                            <li>
                                <b>{{ Transport::label('engine_number') }}:</b>
                                <span>{{ $lot->lotable->engine_number }}</span>
                            </li>
                            <li>
                                <b>{{ Transport::label('engine_power') }}:</b>
                                <span>{{ $lot->lotable->engine_power }}</span>
                            </li>
                            <li>
                                <b>{{ Transport::label('fuel_type') }}:</b>
                                <span>{{ $lot->lotable->fuel_type }}</span>
                            </li>
                            <li>
                                <b>{{ Transport::label('seats_amount') }}:</b>
                                <span>{{ $lot->lotable->seats_amount }}</span>
                            </li>
                            <li>
                                <b>{{ Transport::label('standings_amount') }}:</b>
                                <span>{{ $lot->lotable->standings_amount }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        Автотранспорт эгаси
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingOne"
                     data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <ul class="describe-list">
                            <li>
                                <b>{{ Transport::label('owner') }}:</b>
                                <span>{{ $lot->lotable->owner }}</span>
                            </li>
                            <li>
                                <b>{{ Transport::label('address') }}:</b>
                                <span>{{ $lot->lotable->address }}</span>
                            </li>
                            <li>
                                <b>{{ Transport::label('contract') }}:</b>
                                <span>{{ $lot->lotable->contract }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                        Автотранспорт документлари
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingOne"
                     data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        @php
                            $documents = $lot->lotable->docAttachments;
                        @endphp
                        <div class="lot-documents-list">
                            @foreach ($documents as $document)
                                <a href="{{ asset('storage/' . $document->file_path) }}"
                                   download="{{ $document->file_name }}">
                                    <div class="lot-document">
                                        <img src="{{ asset('auction-app/assets/images/doc.png') }}" alt="document">
                                        <div class="lot-document-name">
                                            <p>{{ $document->file_name }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
