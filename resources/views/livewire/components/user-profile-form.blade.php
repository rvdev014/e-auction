<div>
    <div class="dashboard-profile">

        <div class="owner">
            <div class="content">
                <h3>{{ $user->name ?? '---' }}</h3>
                <p class="para">Менинг маълумотларим</p>
            </div>
        </div>

        <div class="form-wrapper">
            <form
                method="post"
                wire:submit.prevent="onSubmit(Object.fromEntries(new FormData($event.target)))"
            >
                <div class="row">
                    <div class="col-xl-6 col-lg-12 col-md-6">
                        <div class="form-inner">
                            <label for="name">Фамилия Исм Шарифингиз (Тўлиқ ёзинг):</label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ $user->name }}"
                                placeholder="Фамилия Исм Шарифингиз (Тўлиқ ёзинг)"
                            />
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-6">
                        <div class="form-inner">
                            <label for="phone">Телефон рақам:</label>
                            <input
                                id="phone"
                                type="text"
                                placeholder="Телефон рақам"
                                value="{{ $user->phone }}"
                                readonly
                            />
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-6">
                        <div class="form-inner">
                            <label for="lots_member_number">Аукционда қатнашиш учун фишка рақами:</label>
                            <input
                                id="lots_member_number"
                                type="text"
                                value="{{ $user->lots_member_number }}"
                                placeholder="Аукционда қатнашиш учун фишка рақами"
                                readonly
                            />
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-6">
                        <div class="form-inner">
                            <label for="stir">СТИР:</label>
                            <input
                                id="stir"
                                name="stir"
                                type="text"
                                value="{{ $user->stir }}"
                                placeholder="СТИР"
                            />
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-6">
                        <div class="form-inner">
                            <label for="birth_date">Туғилган кун:</label>
                            <input
                                id="birth_date"
                                name="birth_date"
                                type="date"
                                value="{{ $user->birth_date }}"
                                placeholder="Туғилган кун"
                            />
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-6">
                        <div class="form-inner">
                            <label for="address">Манзил:</label>
                            <input
                                id="address"
                                name="address"
                                type="text"
                                value="{{ $user->address }}"
                                placeholder="Манзил"
                            />
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-6">
                        <div class="form-inner" wire:ignore>
                            <label for="region_id">Вилоят/Шаҳар:</label>
                            <select id="region_id" name="region_id" wire:model.live="region_id">
                                <option value=""></option>
                                @foreach($regions as $region)
                                    <option
                                        value="{{ $region->id }}"
                                        @if($region->id == $user->region_id) selected @endif
                                    >{{ $region->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-6">
                        <div class="form-inner">
                            <label for="district_id">Туман/Шаҳар:</label>
                            <select id="district_id" name="district_id" wire:model="district_id">
                                @foreach($districts as $district)
                                    <option
                                        value="{{ $district->id }}"
                                        @if($district->id == $user->district_id) selected @endif
                                    >{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-6">
                        <div class="form-inner">
                            <label for="passport">Паспорт серияси ва рақами:</label>
                            <input
                                id="passport"
                                name="passport"
                                type="text"
                                value="{{ $user->passport }}"
                                placeholder="Паспорт серияси ва рақами"
                            />
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-6">
                        <div class="form-inner">
                            <label for="passport_date">Паспорт берилган сана:</label>
                            <input
                                id="passport_date"
                                name="passport_date"
                                type="date"
                                value="{{ $user->passport_date }}"
                                placeholder="01.01.2024"
                            />
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-6">
                        <div class="form-inner">
                            <label for="passport_given">Паспорт ким томонидан берилган:</label>
                            <input
                                id="passport_given"
                                name="passport_given"
                                type="text"
                                value="{{ $user->passport_given }}"
                                placeholder="01.01.2024"
                            />
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-6">
                        <div class="form-inner">
                            <label for="pinfl">ЖШШИР</label>
                            <input
                                id="pinfl"
                                name="pinfl"
                                type="text"
                                value="{{ $user->pinfl }}"
                                placeholder="ЖШШИР"
                            />
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-6">
                        <div class="form-inner">
                            <label for="email">Электрон почта:</label>
                            <input
                                id="email"
{{--                                name="email"--}}
                                type="text"
                                value="{{ $user->email }}"
                                placeholder="Электрон почта"
                                readonly
                            />
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-6">
                        <div class="form-inner">
                            <label for="additional_phone">Қўшимча телефон:</label>
                            <input
                                id="additional_phone"
                                name="additional_phone"
                                type="text"
                                value="{{ $user->additional_phone }}"
                                placeholder="Қўшимча телефонлар"
                            />
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-6">
                        <div class="form-inner">
                            <label for="type">Жисмоний/Юридик шахс: <sup style="color: red">*</sup></label>
                            <select id="field_type" name="type" wire:model="type">
                                <option></option>
                                <option value="1" @if($user->type == '1') selected @endif>Жисмоний шахс</option>
                                <option value="2" @if($user->type == '2') selected @endif>Юридик шахс</option>
                            </select>
                            @error('type') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-6">
                        <div class="form-inner">
                            <label for="type">Файл юклаш: </label>
                            <input id="files" type="file" wire:model="files" multiple/>
                            <div wire:loading wire:target="files">Uploading...</div>
                            @error('files') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        @if ($user->attachments->isNotEmpty())
                            <div class="form-inner">
                                <label for="type">Юкланган файллар: </label>
                                <ul>
                                    @foreach($user->attachments as $file)
                                        <li>
                                            <a href="{{ $file->file_path }}" target="_blank">{{ $file->file_name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

                <button
                    type="submit"
                    class="eg-btn btn--primary"
                    wire:loading.attr="disabled"
                    wire:target="files"
                >Сақлаш</button>
            </form>
        </div>
    </div>
</div>

@script
<script>

    Livewire.on('regionIdUpdated', (regionId) => {
        const districtSelect = document.getElementById('district_id');
        setTimeout(() => {
            $(districtSelect).niceSelect();
        }, 100);
    });

    $(document).on('change', '#field_type', function (e) {
        console.log('e.target.value', e.target.value)
        $wire.set('type', e.target.value);
    });

    $(document).on('change', '#region_id', function (e) {
        $wire.set('region_id', e.target.value);
    });

    $(document).on('change', '#district_id', function (e) {
        $wire.set('district_id', e.target.value);
    });
</script>
@endscript
