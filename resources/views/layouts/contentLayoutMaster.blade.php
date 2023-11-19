@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

<!DOCTYPE html>
@php
$configData = Helper::applClasses();
@endphp

<html class="loading {{ ($configData['theme'] === 'light') ? '' : $configData['layoutTheme']}}"
lang="@if(session()->has('locale')){{session()->get('locale')}}@else{{$configData['defaultLanguage']}}@endif"
data-textdirection="{{ env('MIX_CONTENT_DIRECTION') === 'rtl' ? 'rtl' : 'ltr' }}"
@if($configData['theme'] === 'dark') data-layout="dark-layout" @endif>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="Cactus Digital - www.cactusweb.gr">
  <meta name="keywords" content="Cactus Digital Growth">
  <meta name="author" content="Dimitris Angeloudis">
  <title>@yield('title') - CactusWeb</title>
  <link rel="apple-touch-icon" href="{{asset('images/ico/apple-icon-120.png')}}">
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/logo/favicon.ico')}}">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fira Sans:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/all.min.js" integrity="sha512-rpLlll167T5LJHwp0waJCh3ZRf7pO6IT1+LZOhAyP6phAirwchClbTZV3iqL3BMrVxIYRbzGTpli4rfxsCK6Vw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- Include core + vendor Styles --}}
  @include('panels/styles')

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
@isset($configData["mainLayoutType"])
@extends((( $configData["mainLayoutType"] === 'horizontal') ? 'layouts.horizontalLayoutMaster' :
'layouts.verticalLayoutMaster' ))
@endisset
