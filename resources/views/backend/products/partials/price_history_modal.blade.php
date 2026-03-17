
<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm text-center">
        <thead class="table-light">
            <tr>
                <th>วันที่ปรับเปลี่ยน</th>
                <th>ราคาทุน</th>
                <th>ราคาขาย</th>
                <th>ราคาโปรโมชั่น</th>
                <th>ผู้ดำเนินการ</th>
            </tr>
        </thead>
        <tbody>
            @forelse($product->priceHistories as $history)
                <tr>
                    <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                    
                    <td class="text-end">{{ number_format($history->cost_price, 2) }}</td>
                    
                    <td class="text-end fw-bold text-primary">{{ number_format($history->price, 2) }}</td>
                    
                    <td class="text-end text-danger">
                        {{ $history->sale_price ? number_format($history->sale_price, 2) : '-' }}
                    </td>
                    
                    <td>{{ optional($history->user)->name ?? 'ผู้ดูแลระบบ' }}</td>
                    
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">ยังไม่มีประวัติการปรับราคา</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>