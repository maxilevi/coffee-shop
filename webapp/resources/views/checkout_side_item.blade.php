<div class="uk-grid-small" uk-grid>
    <div class="uk-width-expand">
        <div class="uk-text-small">{{ $product->name }} × 250gr</div>
        <div class="uk-text-meta">{{ $product->amount }} × ${{ $product->price }}</div>
    </div>
    <div class="uk-text-right uk-text-emphasis">
        <div>${{ $product->value }}</div>
    </div>
</div>