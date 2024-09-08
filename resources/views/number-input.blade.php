<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
    :plusIcon="$getPlusIcon()"
>
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}'),
        disabled: {{ $isDisabled()?$isDisabled():'false' }},
        incrementDisabled: false,
        decrementDisabled: false,
        inputError:null,
        init(){
            this.checkDisabled()
        },
        increase() {
            this.$refs.numberInput.stepUp()
            this.state = Number(this.$refs.numberInput.value)
            this.validateData()
            this.checkDisabled()
            $wire.$set('{{ $getStatePath() }}', this.state)
        },
        decrease(){
            this.$refs.numberInput.stepDown()
            this.state = Number(this.$refs.numberInput.value)
            this.validateData()
            this.checkDisabled()
            $wire.$set('{{ $getStatePath() }}', this.state)
        },
        checkDisabled() {
            let value = this.$refs.numberInput.value ? Number(this.$refs.numberInput.value) : (this.state ? this.state : null)
            let max = this.$refs.numberInput.max ? Number(this.$refs.numberInput.max) : null
            let min = this.$refs.numberInput.min ? Number(this.$refs.numberInput.min) : null

            if(max != null && value >= max){
                this.incrementDisabled = true
            }else{
                this.incrementDisabled = false
            }
            if(min != null && value <= min){
                this.decrementDisabled = true
            }else{
                this.decrementDisabled = false
            }
        },
        validateData(){
            this.inputError = null
            let value = this.$refs.numberInput.value ? Number(this.$refs.numberInput.value) : null
            if(value == null){
                return 
            }
            if(this.$refs.numberInput.min && value < Number(this.$refs.numberInput.min)){
                this.inputError = 'The input value must greater than or equal to <span class=\'font-bold\'>' + this.$refs.numberInput.min + '</span>.'
                return
            }
            if(this.$refs.numberInput.max && value > Number(this.$refs.numberInput.max)){
                this.inputError = 'The input value must less than or equal to <span class=\'font-bold\'>' + this.$refs.numberInput.max + '</span>.'
                return
            }
            return true
        },
        onInput(){
            this.state = this.$refs.numberInput.value ? Number(this.$refs.numberInput.value) : null
            this.validateData()
            this.checkDisabled()
        }
    }">
        <div {{ $attributes->class(["relative flex items-center"])->merge($getExtraInputAttributes())}}>
            <button x-on:click="decrease()" type="button" id="decrement-button" data-input-counter-decrement="quantity-input"
                :disabled="decrementDisabled || disabled"
                class="bg-gray-100 disabled:bg-gray-400 disabled:hover:bg-gray-400 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg py-2.5 px-3 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                <x-filament::icon
                    class="w-4 h-4 text-gray-900 dark:text-white"
                    stroke-width="2"
                    :icon="$getMinusIcon()"
                >
                    <svg class="w-4 h-4 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                    </svg>
                </x-filament::icon>
            </button>
            <input 
                x-ref="numberInput"
                {{ $applyStateBindingModifiers('wire:model') }}="{{ $getStatePath() }}"
                type="number"
                id="{{ $getId() }}"
                x-model = "state"
                aria-describedby="helper-text-explanation"
                placeholder="0"
                {!! ($placeholder = $getPlaceholder()) ? "placeholder=\"{$placeholder}\"" : null !!}
                {!! ($interval = $getStep()) ? "step=\"{$interval}\"" : null !!}
                {!! $isDisabled()||$isManualInputDisabled() ? 'disabled' : null !!}
                @if (! $isConcealed())
                    {!! filled($value = $getMaxValue()) ? "max=\"{$value}\"" : null !!}
                    {!! filled($value = $getMinValue()) ? "min=\"{$value}\"" : null !!}
                    {!! $isRequired() ? 'required' : null !!}
                @endif
                x-on:blur="onInput()"
                x-on:change="onInput()"
                class="bg-gray-50 border-x-0 border-y border-gray-300 outline-none text-center text-gray-900 text-base sm:text-sm sm:leading-6 focus:ring-primary-500 focus:border-primary-500 block w-full py-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 filament-number-input"
            >
            <button x-on:click="increase()" type="button" id="increment-button" data-input-counter-increment="quantity-input"
                :disabled="incrementDisabled || disabled"
                class="bg-gray-100 stroke-2 disabled:bg-gray-400 disabled:hover:bg-gray-400 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg px-3 py-2.5 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                <x-filament::icon
                    class="w-4 h-4 text-gray-900 dark:text-white"
                    stroke-width="2"
                    :icon="$getPlusIcon()"
                >
                    <svg class="w-4 h-4 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                    </svg>
                </x-filament::icon>
            </button>
        </div>
        <template x-if="inputError">
            <div class="text-danger-400" x-html="inputError"></div>
        </template>
    </div>
    <style>
        .filament-number-input::-webkit-outer-spin-button,
        .filament-number-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }
        .filament-number-input {
            -moz-appearance: textfield;
        }
    </style>
</x-dynamic-component>
