<style>
    .panel-messages{
        border-bottom:none; 
        border-radius:10px;
        padding: 100px 0;
        text-align: center;
        color:#CCC;
    }

    .panel-icon{
        font-size:80px;
    }
</style>

<!--Panel Messages-->
<div class="card-header panel-messages">
    {{ $icon }} <br>
    {{ $message }}
</div>