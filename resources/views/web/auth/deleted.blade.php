@extends('web.layouts.app')
@section('title')
    {{ __('web.login') }}
@endsection
@section('content')
    <div class="login-section">
        <div class="image-layer" style="background-image: url({{asset('web_front/images/background/login.jpeg')}});"></div>
        <div class="outer-box">
            <!-- Login Form -->
            <div class="login-form default-form">
                <div class="form-inner" >
                    <!--Login Form-->
                    <div class="form-group" style="padding-bottom: 700px">
                        <h2>Munkáltatói profil törlése</h2>
                        <br>
                        <?php

                        if($success){
                            ?>
                            <p>
                                Munkáltatói profiljnak törlése sikeres volt.<br>
                                Kérjük térjen vissza a <a href="/">főoldalra</a>.
                            </p>
                            <?php
                        }else{
                            ?>
                            <p>
                                Munkáltatói profil törlése sikertelen az URL-ben lévő adatok nem egyeznek a nyilvántartásunkkal.<br>
                                Kérjük térjen vissza a <a href="/">főoldalra</a>.
                            </p>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
