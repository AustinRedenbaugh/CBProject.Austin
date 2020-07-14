

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

<?php $__env->startSection('content'); ?>
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
                <?php if(count($states) > 0): ?>
                    <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value=<?php echo e($state->id); ?>><?php echo e($state->abbreviation); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </select>
        </div>
        <div class = "column" style="float:left; margin:20px;">
            <label for="zip">Bad Zip Code:</label>
            <select name="zip" id="zip">
                <option>-- select --</option>
                <?php if(count($uniqzips) > 0): ?>
                    <?php $__currentLoopData = $uniqzips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uniqzip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option><?php echo e($uniqzip); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </select>
        </div>
        <br><br>
        <input type="submit" name="submit" value="Submit">
    </form>
</div>


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
    <span class="halftab"></span>"state": "<?php echo e($mystate[0]->name); ?>",<br>
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
    <?php $__currentLoopData = $counties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $county): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
    <span class="tab"></span><span class="halftab"></span>"name": <?php echo e($county); ?>,<br>
    <span class="tab"></span><span class="halftab"></span>"cities": [<br>
    <?php
                if (count($countysCities) > 1) {
                    for ($x = 0; $x < count($countysCities); $x++) {
                        if ($x != count($countysCities)-1) {
    ?>
                    <span class="tab"></span><span class="tab"></span>{<br>
                    <span class="tab"></span><span class="tab"></span><span class="halftab"></span>"name": "<?php echo e($countysCities[$x]->city_name); ?>",<br>
                    <span class="tab"></span><span class="tab"></span><span class="halftab"></span>"zip": "<?php echo e($countysCities[$x]->zip); ?>"<br>
                    <span class="tab"></span><span class="tab"></span>},<br>
    <?php
                        } else {
    ?>
                    <span class="tab"></span><span class="tab"></span>{<br>
                    <span class="tab"></span><span class="tab"></span><span class="halftab"></span>"name": "<?php echo e($countysCities[$x]->city_name); ?>",<br>
                    <span class="tab"></span><span class="tab"></span><span class="halftab"></span>"zip": "<?php echo e($countysCities[$x]->zip); ?>"<br>
                    <span class="tab"></span><span class="tab"></span>}<br>
    <?php
                        }
                    }
                } else {
    ?>
            <span class="tab"></span><span class="tab"></span>{<br>
            <span class="tab"></span><span class="tab"></span><span class="halftab"></span>"name": "<?php echo e($countysCities[0]->city_name); ?>",<br>
            <span class="tab"></span><span class="tab"></span><span class="halftab"></span>"zip": "<?php echo e($countysCities[0]->zip); ?>"<br>
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
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <span class="tab"></span>}<br>
    <span class="halftab"></span>]<br> 
    }
    <?php
        } else {
            
        }
    ?>
</div>
<br><br>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/code/CBProject/resources/views/pages/index.blade.php ENDPATH**/ ?>