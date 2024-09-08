<?php
use Filament\Forms\ComponentContainer;
use Vicmans\FilamentNumberInput\NumberInput;
use Vicmans\FilamentNumberInput\Tests\Fixtures\Livewire;

it('can test', function () {
    expect(true)->toBeTrue();
});

it('can render page', function () {
    $field = (new NumberInput($name = 'test-component'))
        ->container(ComponentContainer::make(Livewire::make()));

    expect($field)
        ->getStatePath()->toBe($name);

    expect($field)
        ->isManualInputDisabled()->toBeFalse();
});