<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{-- styles --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">


    <style>
        label.error{color: red;}
    </style>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">{{ __('Submit Form') }}</div>
        
                            <div class="card-body">
                                <form method="POST" action="{{ route('form.check') }}" onsubmit="return validateData()">
                                    @csrf
        
                                    <div class="row mb-3">
                                        <label for="company_symbol" class="col-md-4 col-form-label text-md-end">{{ __('Company Symbol') }}</label>
        
                                        <div class="col-md-6">
                                            <input id="company_symbol" type="text" class="form-control @error('company_symbol') is-invalid @enderror"
                                            onkeyup="validateSymbol()"
                                            name="company_symbol" value="{{ old('company_symbol') }}" required autocomplete="company_symbol" autofocus>
        
                                            <p class="text-danger m-0" id="company_symbol_error" >
                                                @error('company_symbol'){{ $message }}@enderror
                                            </p>
                                            
                                        </div>
                                    </div>
        
                                    <div class="row mb-3">
                                        <label for="start_date" class="col-md-4 col-form-label text-md-end">{{ __('Start Date') }}</label>
        
                                        <div class="col-md-6">
                                            <input id="start_date" type="text" class="form-control @error('start_date') is-invalid @enderror" 
                                            max="{{ date('Y-m-d') }}"  
                                            onchange="validateDates()"
                                            name="start_date" value="{{ old('start_date') }}" required autocomplete="start_date">
        
                                            <p class="text-danger m-0" id="start_date_error" >
                                                @error('start_date'){{ $message }}@enderror
                                            </p>
                                        </div>
                                    </div>
        
                                    <div class="row mb-3">
                                        <label for="end_date" class="col-md-4 col-form-label text-md-end">{{ __('End Date') }}</label>
        
                                        <div class="col-md-6">
                                            <input id="end_date" type="text" class="form-control @error('end_date') is-invalid @enderror" 
                                                max="{{ date('Y-m-d') }}"
                                                onchange="validateDates()"
                                                name="end_date" value="{{ old('end_date') }}"  required autocomplete="end_date">
        
                                            <p class="text-danger m-0" id="end_date_error" >
                                                @error('end_date'){{ $message }}@enderror
                                            </p>
                                        </div>
                                    </div>
        
                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>
        
                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" onkeyup="validateMail()" value="{{ old('email') }}" required autocomplete="email">
        
                                            <p class="text-danger m-0" id="email_error" >
                                                @error('email'){{ $message }}@enderror
                                            </p>
                                        </div>
                                    </div>

        
                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" name="submit" class="btn btn-primary">submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(function(){
            $("#start_date,#end_date").datepicker({
                dateFormat: "yy-mm-dd"
            });
        });

        function validateData(){
            if(validateSymbol() && validateDates() && validateMail()){
                return true;
            }
            return false;
        }

        function validateSymbol(){
            let symbolElement=$("#company_symbol");
            if(symbolElement.val()!=''){
                $(symbolElement).val($(symbolElement).val().toUpperCase());
                let symbols=parseJson();
                if(symbols.includes(symbolElement.val())){
                    showValidationAlert('company_symbol','success',' ');
                    return true;
                }   
            }
            
            showValidationAlert('company_symbol','error','company symbol is not valid');
            return false;

        }


        function validateDates(){

            let startDate=$('#start_date').val();
            let startDateTime=new Date(startDate).getTime();
            let endDate=$('#end_date').val();
            let endDateTime=new Date(endDate).getTime();
            let currentDateTime = new Date().getTime();
            

            result=true;
            if(!startDate){
                showValidationAlert('start_date','error','start date is required');
                result=false;
            }else if(!isValidDate(startDate)){
                showValidationAlert('start_date','error','invalid start date');
                result=false;
            }else if(currentDateTime <= startDateTime){
                showValidationAlert('start_date','error','start date is greater than current date');
                result=false;
            }else if(endDate && endDateTime < startDateTime){
                showValidationAlert('start_date','error','start date is greater than end date');
                result=false;
            }

            if(!endDate){
                showValidationAlert('end_date','error','end date is required');
                result=false;
            }else if(!isValidDate(endDate)){
                showValidationAlert('end_date','error','invalid end date');
                result=false;
            }else if(currentDateTime <= endDateTime){
                showValidationAlert('end_date','error','end date is greater than current date');
                result=false;
            }else if(startDate && endDateTime < startDateTime){
                showValidationAlert('end_date','error','end date is less than start date');
                result=false;
            }

            if(!result){
                return result;
            }
            
            showValidationAlert('start_date','success',' ');
            showValidationAlert('end_date','success',' ');
            return result;


        }

        function validateMail(){
            let regex = /^[a-z0-9]+@[a-z]+\.[a-z]{2,3}$/;
            let result = regex.test($('#email').val());

            if(!result){
                showValidationAlert('email','error','email is not valid');
                return false;
            }

            showValidationAlert('email','success',' ');
            return true;

        }

        function showValidationAlert(id,type,msg){
            if(type=='error'){
                $('#'+id).focus();
                $('#'+id).removeClass('border-success').addClass('border-danger');
            }else{
                $('#'+id).removeClass('border-danger').addClass('border-success');
            }
            $("#"+id+"_error").html(msg);

        }

        function isValidDate(str){
            // STRING FORMAT yyyy-mm-dd
            if(str=="" || str==null){return false;}								
            
            // m[1] is year 'YYYY' * m[2] is month 'MM' * m[3] is day 'DD'					
            var m = str.match(/(\d{4})-(\d{2})-(\d{2})/);
            
            // STR IS NOT FIT m IS NOT OBJECT
            if( m === null || typeof m !== 'object'){return false;}				
            
            // CHECK m TYPE
            if (typeof m !== 'object' && m !== null && m.size!==3){return false;}
                        
            var ret = true; //RETURN VALUE						
            var thisYear = new Date().getFullYear(); //YEAR NOW
            var minYear = 1999; //MIN YEAR
            
            // YEAR CHECK
            if( (m[1].length < 4) || m[1] < minYear || m[1] > thisYear){ret = false;}
            // MONTH CHECK			
            if( (m[2].length < 2) || m[2] < 1 || m[2] > 12){ret = false;}
            // DAY CHECK
            if( (m[3].length < 2) || m[3] < 1 || m[3] > 31){ret = false;}
            
            return ret;			
        }


        function parseJson(){
            var Httpreq = new XMLHttpRequest(); // a new request
            Httpreq.open("GET",'https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json',false);
            Httpreq.send(null);
            let data=JSON.parse(Httpreq.responseText);
            return data.map(function(value) {
                return value['Symbol'];
            });
            
            
        }
        
    </script>
</body>
</html>
