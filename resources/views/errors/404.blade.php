@extends('layouts.app')

@section('content')       
<style type="text/css">
body { background-color: #fbfbfb; color: #555555; font-family: sans-serif;  margin: 0; }
h1 { color: #aeaeae; font-size: 80px; text-align: center; padding-top:50px; }
h2 { color: #aeaeae; font-size: 50px; text-align: center; }
p.msg { color: #cccccc; font-size: 21px; text-align: center; }
p.msg2 { color: #aaa; font-size: 16px; text-align: center; }
a {color:#1a0dab;  }
a:hover {text-decoration:underline; color:#1a0dab;   }
</style>

       


    <div class="wrapper">
        <div class="error-spacer"></div>
        <div role="main" class="main">
            <?php $messages = array('Oops! Something went wrong.', 'I think we\'re lost.', 'We took a wrong turn.'); ?>

            <h1>404 :(</h1>
            <h2><?php echo $messages[mt_rand(0, 2)]; ?></h2>

            <!-- <p class="msg">I'm so sorry. 674,258 rainbow unicorns died because of this.</p> -->

            <p class="msg2">
                Perhaps you would like to go to our <a href="{{{ URL::to('/') }}}">home page</a>?
            </p>
        </div>
    </div>
@endsection



