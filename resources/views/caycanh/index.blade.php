<h1>Danh sách Cây cảnh</h1>
<a href="{{ route('caycanh.create') }}">Thêm Cây cảnh</a>
<table>
    <tr>
        <th>Mã cây</th>
        <th>Tên cây</th>
        <th>Mô tả</th>
        <th>Số lượng</th>
        <th>Giá</th>
        <th>Ngày tạo</th>
    </tr>
    @foreach($cayCanh as $cay)
    <tr>
        <td>{{ $cay->ma_cay }}</td>
        <td>{{ $cay->ten_cay }}</td>
        <td>{{ $cay->mo_ta }}</td>
        <td>{{ $cay->so_luong }}</td>
        <td>{{ $cay->gia }}</td>
        <td>{{ $cay->ngay_tao }}</td>
    </tr>
    @endforeach
</table>
