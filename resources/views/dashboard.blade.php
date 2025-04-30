@php
    $cards = \App\Models\Card::all();
@endphp

<x-app-layout>
    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- SortableJS --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <div class="container py-4">

        {{-- Add New Card Form --}}
        <form action="{{ route('cards.store') }}" method="POST" class="row g-2 mb-4">
            @csrf
            <div class="col-md-5">
                <input type="text" name="title" placeholder="Card title" class="form-control" required>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="ToDo">ToDo</option>
                    <option value="InProgress">In Progress</option>
                    <option value="Testing">Testing</option>
                    <option value="Done">Done</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Add Card</button>
            </div>
        </form>

        {{-- Kanban Board --}}
        <div class="row g-4">
            @foreach (['ToDo', 'InProgress', 'Testing', 'Done'] as $list)
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header text-white fw-bold text-center
                            @if($list == 'ToDo') bg-secondary
                            @elseif($list == 'InProgress') bg-warning
                            @elseif($list == 'Testing') bg-info
                            @else bg-success @endif">
                            {{ $list }}
                        </div>
                        <div class="card-body p-2 min-vh-50" id="list-{{ $list }}" style="min-height: 300px;">
                            @foreach ($cards->where('status', $list) as $card)
                                <div class="card mb-2 shadow-sm" data-id="{{ $card->id }}">
                                    <div class="card-body p-2">

                                        {{-- Top Row: Title + Delete --}}
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            {{-- Editable title --}}
                                            <h6 class="card-title mb-0" ondblclick="enableEdit(this)" data-id="{{ $card->id }}">
                                                {{ $card->title }}
                                            </h6>

                                            {{-- Delete --}}
                                            <form action="{{ route('cards.destroy', $card) }}" method="POST" onsubmit="return confirm('Delete?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger">x</button>
                                            </form>
                                        </div>

                                        {{-- Created By --}}
                                        <small class="text-muted">Created by: {{ $card->user->name }}</small>

                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

    </div>

    {{-- Drag & Drop + Inline Edit Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Drag & Drop
            ['ToDo', 'InProgress', 'Testing', 'Done'].forEach(status => {
                new Sortable(document.getElementById('list-' + status), {
                    group: 'kanban',
                    animation: 150,
                    onEnd: function (evt) {
                        let cardId = evt.item.dataset.id;
                        let newStatus = evt.to.id.replace('list-', '');

                        fetch(`/cards/${cardId}/status`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ status: newStatus })
                        }).then(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Task Moved!',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        });
                    }
                });
            });
        });

        // Inline Edit
        function enableEdit(el) {
            let currentTitle = el.innerText;
            let cardId = el.dataset.id;

            let input = document.createElement('input');
            input.type = 'text';
            input.value = currentTitle;
            input.className = 'form-control form-control-sm';
            input.style.width = '70%';

            // Replace span with input
            el.replaceWith(input);
            input.focus();

            input.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    let newTitle = this.value;

                    fetch(`/cards/${cardId}/title`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ title: newTitle })
                    }).then(() => {
                        // Replace input back with span
                        let span = document.createElement('span');
                        span.className = 'card-title';
                        span.dataset.id = cardId;
                        span.ondblclick = function () { enableEdit(this); };
                        span.innerText = newTitle;

                        this.replaceWith(span);

                        // Success alert
                        Swal.fire({
                            icon: 'success',
                            title: 'Title Updated!',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    });
                }
            });
        }

        @if(session()->get('success'))

        Swal.fire({
            icon: 'success',
            title: '{{session()->get('success')}}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500
        });

         @endif

    </script>
</x-app-layout>
