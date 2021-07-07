<?php
$types = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];
$data = session()->all();
?>
@foreach ($types as $type)
    @if(session()->get($type))
        <?php
        $message = session()->get($type);
        session()->remove($type);
        ?>
        <div class="alert alert-{{$type}}" role="alert">
            {{$message}}
        </div>
    @endif
@endforeach


