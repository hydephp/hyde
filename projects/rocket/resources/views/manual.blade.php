@extends('partials.layout')
@section('title', 'Manual')
@section('content')

<style>
    h1, h2, h3, h4, h5, h6 {
        margin-bottom: 0;
    }
</style>

<pre>

<h1>Hyde Rocket Manual</h1>
    This manual is a work in progress.

    In many places, you can hover over an area to see a description of what it does.


<h2>The Dashboard and its sections</h2>
    The dashboard gives you convenient access to your Hyde project.

<h3>Project Overview</h3>
    The project overview section gives you information about your project.

<h2>Hyde Realtime Compiler (HydeRC) integration</h2>
    Rocket ships with an integration with the HydeRC.

    Rocket expects the HydeRC be running on localhost port 8080.
</pre>

@endsection
