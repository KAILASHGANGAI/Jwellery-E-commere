@extends('admin::layouts.master')
@section('style')
    <style>
        .header1 {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header1 h1 {
            font-size: 24px;
            margin: 0;
        }

        .header1-actions button,
        button {
            margin-left: 10px;
            font-size: 12px;
            cursor: default;
            box-sizing: border-box;
            background-color: buttonface;
            margin: 0em;
            padding-block: 1px;
            padding-inline: 6px;
            border-width: 2px;
            border-style: outset;
            border-color: buttonborder;
            border-image: initial;
            text-rendering: auto;
            color: buttontext;
            letter-spacing: normal;
            word-spacing: normal;
            line-height: normal;
            text-transform: none;
            text-indent: 0px;
            text-shadow: none;
            display: inline-block;
            text-align: center;
        }

        .main-content2 {
            display: flex;
            gap: 20px;
        }

        .left-column {
            flex: 2;
        }

        .right-column {
            flex: 1;
        }

        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .card h2 {
            margin-top: 0;
            font-size: 18px;
        }

        .product-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .product-image {
            width: 50px;
            height: 50px;
            background-color: #f0f0f0;
            margin-right: 10px;
        }


        .order-summary div {
            display: flex;
            justify-content: space-between;
        }

        .timeline {
            margin-top: 20px;
        }

        .comment-form {
            display: flex;
            margin-top: 10px;
        }

        .comment-form input {
            flex-grow: 1;
            margin-right: 10px;
        }

        .tag {
            background-color: #f0f0f0;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
        }

        .editable {
            display: inline-block;
            min-width: 50px;
            min-height: 1em;
        }

        .edit-mode .editable {
            border-bottom: 1px dashed #999;
            cursor: pointer;
        }

        .editing {
            border: 1px solid #999;
            padding: 2px;
        }

        .edit-controls {
            display: none;
            margin-top: 20px;
        }

        .edit-mode .edit-controls {
            display: block;
        }

        .save-indicator {
            display: none;
            color: green;
            margin-left: 10px;
        }
    </style>
@endsection

@section('content')
    <h5>Order Details</h5>
    <div class="header1">
        <h1><a class="text-decoration-none text-dark fw-bold" href="{{ route('orders.index') }}">←</a>
            #<span>{{ $order->id }}</span> <span class="tag editable"
                data-field="status">{{ strtoupper($order->status) }}</span></h1>
        <div class="header1-actions">
            <button onclick="saveField('status', 'refund')">Refund</button>
            <button onclick="saveField('status', 'fulfilled')">Fulfilled</button>
            <button onclick="saveField('status', 'refund')">Refund</button>
            <button onclick="saveField('status', 'cancled')">Cancled</button>

            <button onclick="toggleEditMode()">Edit</button>
            <button onclick="window.print()">Print</button>
        </div>
    </div>
    <div class="main-content2">
        <div class="left-column">
            <div class="card">
                <h2>{{ ucfirst($order->status) }}</h2>
                <p>Delivary Date: <span class="editable" data-field="deliveryDate">{{ $order->delivery_date }}</span></p>
                <p>Delivery method: <span class="editable" data-field="deliveryMethod">Free Shipping</span></p>
                @foreach ($order->orderProducts as $index => $item)
                    <div class="product-item">
                        <div class="d-flex">
                            <div class="product-image"> <img src="{{ asset($item->product->images[0]->image_path) }}"
                                    class="w-100" alt="" srcset=""></div>
                            <div>
                                <strong>{{ $item->product->title }}</strong>

                                <p>SKU: <span>{{ $item->sku }}</span></p>
                            </div>
                        </div>
                        <div>
                            <p>NPR. <span class="editable" data-field="price">{{ $item->unitPrice }}</span> x <span
                                    class="editable" data-field="quantity">{{ $item->quantity }}</span></p>
                            <strong>NPR. <span class="editable" data-field="total">{{ $item->subtotal }}</span></strong>
                        </div>
                    </div>
                    <hr class="m-1">
                @endforeach

            </div>

            <div class="card">
                <h2>Payment Details</h2>
                <div class="order-summary">

                    <div><span>Subtotal</span><span>NPR. <span class="editable"
                                data-field="subtotal">{{ $order->subtotal }}</span></span></div>
                    <div><span>Discount</span><span>NPR. <span class="editable"
                                data-field="taxes">{{ $order->discount }}</span></span></div>
                    <div><span>Tax Amount (13 %)</span><span>NPR. <span class="editable"
                                data-field="total">{{ $order->taxAmount }}</span></span></div>
                    <div><span>Net payment</span><span>NPR. <span class="editable"
                                data-field="netPayment">{{ $order->total_amount }}</span></span>
                    </div>
                    <hr class="my-1">
                    <div><strong>Net payment</strong><strong>NPR. <span class="editable"
                                data-field="refundOwed">{{ $order->total_amount }}</span></strong></div>
                </div>
            </div>
            <div class="timeline">
                <h2>Timeline</h2>
                <div class="comment-form">
                    <input type="text" placeholder="Leave a comment...">
                    <button onclick="addComment()">Post</button>
                </div>
                <div id="comments"></div>
            </div>
        </div>
        <div class="right-column">
            <div class="card">
                <h2>Notes</h2>
                <p class="editable" data-field="notes">{{ $order->delivaryLocation->note ?? 'No notes provided' }}</p>
            </div>
            <div class="card">
                <h2>Contact information</h2>
                <span class="editable fw-bold" data-field="name">{{ $order->customer->name }}</span>
                <a href="mailto:{{ $order->customer->email }}" class="editable"
                    data-field="email">{{ $order->customer->email }}</a>
                <a href="tel:{{ $order->customer->phone }}" class="editable"
                    data-field="phone">{{ $order->customer->phone }}</a>
                <span class="editable" data-field="address">{{ $order->customer->address }}</span>
                <span>{{ $order->customer->city }}, {{ $order->customer->state }}, {{ $order->customer->zip }}</span>
                <span>{{ $order->customer->country }}</span>
                <h5 class="mt-3">Shipping address</h5>
                <span class="editable fw-bold" data-field="name">{{ $order->delivaryLocation->name }}</span>

                <a href="tel:{{ $order->delivaryLocation->phone }}" class="editable"
                    data-field="phone">{{ $order->delivaryLocation->phone }}</a>
                <span class="editable" data-field="address">{{ $order->delivaryLocation->address }}</span>
                <span>{{ $order->delivaryLocation->city }}, {{ $order->delivaryLocation->state }},
                    {{ $order->delivaryLocation->zip }}</span>
                <span>{{ $order->delivaryLocation->country }}</span>
                <h5 class="mt-3">Billing address</h5>
                <p class="editable" data-field="billingAddress">Same as shipping address / Customer address </p>
            </div>
            {{-- <div class="card">
                <h2>Conversion summary</h2>
                <p class="editable" data-field="conversionSummary">There aren't any conversion details available for this
                    order.</p>
                <a href="#" onclick="alert('Learn more about conversions')">Learn more</a>
            </div> --}}

            <div class="card">
                <h2>Tags</h2>
                <input type="text" placeholder="Add tags...">
            </div>
        </div>
    </div>
    <div class="edit-controls1">
        <button onclick="saveAllChanges()">Save All Changes</button>
        <button onclick="cancelChanges()">Cancel</button>
        <span class="save-indicator">Changes saved successfully!</span>
    </div>
@endsection

@section('script')
    <script>
        let editMode = false;
        let originalData = {};
        let changedFields = new Set();

        function toggleEditMode() {
            editMode = !editMode;
            document.body.classList.toggle('edit-mode', editMode);

            if (editMode) {
                saveOriginalData();
                alert('Edit mode activated. Click on fields to edit.');
            } else {
                alert('Edit mode deactivated.');
            }
        }

        function saveOriginalData() {
            const editables = document.querySelectorAll('.editable');
            editables.forEach(el => {
                originalData[el.dataset.field] = el.textContent;
            });
        }

        function makeEditable(element) {
            if (!editMode) return;

            const currentValue = element.textContent;
            const input = document.createElement('input');
            input.value = currentValue;
            input.classList.add('editing');

            input.onblur = function() {
                if (this.value !== currentValue) {
                    element.textContent = this.value;
                    changedFields.add(element.dataset.field);
                    saveField(element.dataset.field, this.value);
                }
                element.classList.remove('editing');
            };

            input.onkeydown = function(event) {
                if (event.key === 'Enter') {
                    this.blur();
                }
            };

            element.textContent = '';
            element.appendChild(input);
            input.focus();
        }

        function saveField(field, value) {
            var saveUrl = '{{ route('saveField', $order->id) }}';

            fetch(saveUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')

                    },
                    body: JSON.stringify({
                        field,
                        value
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                    if (data.status) {
                        alert(data.message);
                        window.location.href = "{{ route('orders.show', $order->id) }}";
                    } else {
                        alert('Failed to save changes. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while saving. Please try again.');
                });
        }

        function saveAllChanges() {
            const changedData = {};
            changedFields.forEach(field => {
                const element = document.querySelector(`[data-field="${field}"]`);
                changedData[field] = element.textContent;
            });

            fetch('/api/saveAllChanges', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(changedData),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSaveIndicator();
                        changedFields.clear();
                        editMode = false;
                        document.body.classList.remove('edit-mode');
                    } else {
                        alert('Failed to save all changes. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while saving all changes. Please try again.');
                });
        }

        function cancelChanges() {
            const editables = document.querySelectorAll('.editable');
            editables.forEach(el => {
                el.textContent = originalData[el.dataset.field];
            });
            changedFields.clear();
            editMode = false;
            document.body.classList.remove('edit-mode');
            alert('Changes cancelled. Original data restored.');
        }

        function showSaveIndicator() {
            const indicator = document.querySelector('.save-indicator');
            indicator.style.display = 'inline';
            setTimeout(() => {
                indicator.style.display = 'none';
            }, 3000);
        }

        function addComment() {
            const commentInput = document.querySelector('.comment-form input');
            const commentsContainer = document.getElementById('comments');
            if (commentInput.value.trim() !== '') {
                const commentElement = document.createElement('p');
                commentElement.textContent = commentInput.value;
                commentsContainer.prepend(commentElement);
                commentInput.value = '';
            }
        }

        // Add click event listeners to all editable elements
        document.addEventListener('DOMContentLoaded', () => {
            const editables = document.querySelectorAll('.editable');
            editables.forEach(el => {
                el.addEventListener('click', () => makeEditable(el));
            });
        });
    </script>
@endsection
