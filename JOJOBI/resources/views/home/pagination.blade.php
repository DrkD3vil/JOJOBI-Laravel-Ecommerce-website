@if ($products->hasPages())
    <div class="pagination">
        {{ $products->links() }}
    </div>
@endif
