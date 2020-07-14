@extends('layouts.app')

<style>
    .column {
        column-gap: 40px;
    }
    .tab {
        margin-left: 40px; 
    }
    .halftab {
        /* display: inline-block;  */
        margin-left: 20px; 
    }
</style>

@section('content')
<br>
<h1>County and Cities by State API</h1>
<br>
<p>Return all counties and cities for the desired state.</p>
<p>Indicate a zip code to have cities with that zip code excluded from the results.</p>

<?php
use App\State;
use App\CountyAndCitie;

$countyandcities = CountyAndCitie::all();
$states = State::all();

$zips = [];

for ($x = 0; $x < count($countyandcities); $x++) {
    array_push($zips, $countyandcities[$x]->zip);
}

$uniqzips = array_unique($zips);
// print_r($uniqzips);
?>

<div class="row container">
    <form method="GET">
        <div class = "column" style="float:left; margin:20px;">
            <label for="states">State:</label>
            <select name="states" id="states">
                <option>-- select --</option>
                @if(count($states) > 0)
                    @foreach($states as $state)
                        <option value={{$state->id}}>{{$state->abbreviation}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class = "column" style="float:left; margin:20px;">
            <label for="zip">Bad Zip Code:</label>
            <select name="zip" id="zip">
                <option>-- select --</option>
                @if(count($uniqzips) > 0)
                    @foreach($uniqzips as $uniqzip)
                        <option>{{$uniqzip}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <br><br>
        <input type="submit" name="submit" value="Submit">
    </form>
</div>

{{-- Response Section --}}
<div class = "container" style="border: thin solid black">
    Response:<br>
    <?php
        $stateid = '-- select --';
        if(isset($_GET['submit'])) {
            $stateid = $_GET['states'];
            $badzip = $_GET['zip'];
        } 
        $mystate = $states->where('id', $stateid);
        $mystate = $mystate->values();

        if ($stateid != "-- select --") {           
    ?>
    {<br>
    <span class="halftab"></span>"state": "{{$mystate[0]->name}}",<br>
    <span class="halftab"></span>"counties": [<br>
    <span class="tab"></span>{<br>
    <?php
        $counties = [];
            for ($x = 0; $x < count($countyandcities); $x++) {
                if ($countyandcities[$x]->state_id == $stateid && $countyandcities[$x]->zip != $badzip) {
                    array_push($counties, $countyandcities[$x]->county_name);
                }
            }
        $counties = array_unique($counties);
        $lastcounty = 0;
    ?>
    @foreach ($counties as $county)
    <?php
        $lastcounty = $lastcounty + 1;
        $cities = $countyandcities->where('county_name', $county);
        $cities = $cities->values();
        $countysCities = [];
            for ($x = 0; $x < count($cities); $x++) {
                if ($cities[$x]->zip != $badzip) {
                    array_push($countysCities, $cities[$x]);
                }
            }
        $cities = $cities->values();
            if (count($countysCities) > 0) {
    ?>
    <span class="tab"></span><span class="halftab"></span>"name": {{$county}},<br>
    <span class="tab"></span><span class="halftab"></span>"cities": [<br>
    <?php
                if (count($countysCities) > 1) {
                    for ($x = 0; $x < count($countysCities); $x++) {
                        if ($x != count($countysCities)-1) {
    ?>
                    <span class="tab"></span><span class="tab"></span>{<br>
                    <span class="tab"></span><span class="tab"></span><span class="halftab"></span>"name": "{{$countysCities[$x]->city_name}}",<br>
                    <span class="tab"></span><span class="tab"></span><span class="halftab"></span>"zip": "{{$countysCities[$x]->zip}}"<br>
                    <span class="tab"></span><span class="tab"></span>},<br>
    <?php
                        } else {
    ?>
                    <span class="tab"></span><span class="tab"></span>{<br>
                    <span class="tab"></span><span class="tab"></span><span class="halftab"></span>"name": "{{$countysCities[$x]->city_name}}",<br>
                    <span class="tab"></span><span class="tab"></span><span class="halftab"></span>"zip": "{{$countysCities[$x]->zip}}"<br>
                    <span class="tab"></span><span class="tab"></span>}<br>
    <?php
                        }
                    }
                } else {
    ?>
            <span class="tab"></span><span class="tab"></span>{<br>
            <span class="tab"></span><span class="tab"></span><span class="halftab"></span>"name": "{{$countysCities[0]->city_name}}",<br>
            <span class="tab"></span><span class="tab"></span><span class="halftab"></span>"zip": "{{$countysCities[0]->zip}}"<br>
            <span class="tab"></span><span class="tab"></span>}<br>
    <?php
                }
            if ($lastcounty == count($counties)) {
    ?>
                <span class="tab"></span><span class="halftab"></span>]<br>
    <?php
            } else {
    ?>
                <span class="tab"></span><span class="halftab"></span>],<br>
    <?php
            }
            } else {

            }
    ?>
    @endforeach
    <span class="tab"></span>}<br>
    <span class="halftab"></span>]<br> 
    }
    <?php
        } else {
            
        }
    ?>
</div>
<br><br>

@endsection
