@component('mail::message')
# Order Details

**Order ID:** {{ $orderData['id'] }}  
**Customer Name:** {{ $orderData['customer_name'] }}  
**Date:** {{ $orderData['date'] }}

@component('mail::table')
| Product Name       | Quantity | Unit Price | Total Price |
|:-------------------|:--------:|:----------:|:-----------:|
    @foreach ($orderData['products'] as $product)
    | {{ $product['name'] }} | {{ $product['quantity'] }} | {{ number_format($product['price'], 2) }} | {{ number_format($product['price'] * $product['quantity'], 2) }} |
    @endforeach
    @endcomponent

**Total Amount:** {{ number_format($orderData['total_amount'], 2) }}  
@if (!empty($orderData['coupon']))
**Coupon Applied:** {{ $orderData['coupon'] }}
@endif

@component('mail::button', ['url' => $orderData['confirm_url']])
    Xác nhận thanh toán khi nhận hàng
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent