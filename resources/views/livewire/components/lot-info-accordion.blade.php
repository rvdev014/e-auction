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
                                <b>Автотранспорт номи:</b>
                                <span>{{ $lot->lotable->name }}</span>
                            </li>
                            <li>
                                <b>Давлат рақами:</b>
                                <span>{{ $lot->lotable->car_number }}</span>
                            </li>
                            <li>
                                <b>Ишлаб чиқарилган йили:</b>
                                <span>{{ $lot->lotable->year_of_issue }}</span>
                            </li>
                            <li>
                                <b>Ранги:</b>
                                <span>{{ $lot->lotable->color }}</span>
                            </li>
                            <li>
                                <b>Техник ҳолати:</b>
                                <span>{{ $lot->lotable->technical_condition }}</span>
                            </li>
                            <li>
                                <b>Модели:</b>
                                <span>{{ $lot->lotable->model }}</span>
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
                                <b>Автотранспорт эгаси:</b>
                                <span>{{ $lot->lotable->owner }}</span>
                            </li>
                            <li>
                                <b>Манзил:</b>
                                <span>{{ $lot->lotable->address }}</span>
                            </li>
                            <li>
                                <b>Шартнома:</b>
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
