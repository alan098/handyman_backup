<!--filtros-->                                    
<style>
    .switch1 {
    position: relative;
    display: inline-block;
    width: 100%;
    height: 34px;
    }

    .switch1 input { 
    opacity: 0;
    width: 0;
    height: 0;
    }

    .sliround {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgb(104, 80, 242);
    -webkit-transition: .4s;
    transition: .4s;
    }

    .sliround:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 0px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    }

    input:checked + .sliround {
    background-color: #b6f465;
    }

    input:focus + .sliround {
    box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .sliround:before {
    -webkit-transform: translateX(30px);
    -ms-transform: translateX(30px);
    transform: translateX(500px);
    }

    /* Rounded sliders */
    .sliround {
    border-radius: 34px;
    }

    .sliround:before {
    border-radius: 50%;
    }
</style>
{{--  --}}
<style>
    .maximo_tam {
        max-width: 50%;
    }
    .switch {
        position: relative;
        display: inline-block;
        width: 55px;
        height: 27px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 21px;
        width: 21px;
        left: 4px;
        bottom: 3px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
<!--calendarios-->


<style>
    .wrapper1{width: 300px; border: none 0px RED;
    overflow-x: scroll; overflow-y:hidden;}
    .div1 {width:3000px; height: 20px; }
</style>
<style>
    .fc-event-title-container {
        color: black !important;
    }

    .columna_colaborador {
        max-width: 18%;
    }

    .testimonial-group>.row {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }

    .testimonial-group>.row>.col-4 {
        display: inline-block;
    }

    .wrapper1>.div1 {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
    .wrapper1>.div1{
        display: inline-block;
    }
</style>