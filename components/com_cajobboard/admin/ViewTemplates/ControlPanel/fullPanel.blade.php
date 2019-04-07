<?php
 /**
  * Admin Control Panel Full-View Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // no direct access
  defined('_JEXEC') or die;
?>

<div class="row">
  <div class="span12">
    <div class="dashboard_graph">

      <div class="row x_title">
        <div class="col-md-6">
          <h3>Network Activities <small>Graph title sub-title</small></h3>
        </div>
        <div class="col-md-6">
          <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
            <span>March 8, 2019 - April 6, 2019</span> <b class="caret"></b>
          </div>
        </div>
      </div>

      <div class="col-md-9">
        <div
          id="chart_plot_01"
          class="demo-placeholder"
          style="padding: 0px; position: relative;"
        >
          <canvas
            class="flot-base"
            style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 680px; height: 280px;"
            width="1360" height="560">
          </canvas>
          <div
            class="flot-text"
            style="position: absolute; inset: 0px; font-size: smaller; color: rgb(84, 84, 84);"
          ><div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; inset: 0px; display: block;">
            <div style="position: absolute; max-width: 85px; top: 263px; left: 25px; text-align: center;" class="flot-tick-label tickLabel">
              Jan 01</div><div style="position: absolute; max-width: 85px; top: 263px; left: 132px; text-align: center;" class="flot-tick-label tickLabel">
              Jan 02</div><div style="position: absolute; max-width: 85px; top: 263px; left: 238px; text-align: center;" class="flot-tick-label tickLabel">Jan 03</div><div style="position: absolute; max-width: 85px; top: 263px; left: 345px; text-align: center;" class="flot-tick-label tickLabel">Jan 04</div><div style="position: absolute; max-width: 85px; top: 263px; left: 451px; text-align: center;" class="flot-tick-label tickLabel">Jan 05</div><div style="position: absolute; max-width: 85px; top: 263px; left: 558px; text-align: center;" class="flot-tick-label tickLabel">Jan 06</div></div><div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; inset: 0px; display: block;"><div style="position: absolute; top: 250px; left: 13px; text-align: right;" class="flot-tick-label tickLabel">0</div><div style="position: absolute; top: 231px; left: 7px; text-align: right;" class="flot-tick-label tickLabel">10</div><div style="position: absolute; top: 212px; left: 7px; text-align: right;" class="flot-tick-label tickLabel">20</div><div style="position: absolute; top: 192px; left: 7px; text-align: right;" class="flot-tick-label tickLabel">30</div><div style="position: absolute; top: 173px; left: 7px; text-align: right;" class="flot-tick-label tickLabel">40</div><div style="position: absolute; top: 154px; left: 7px; text-align: right;" class="flot-tick-label tickLabel">50</div><div style="position: absolute; top: 135px; left: 7px; text-align: right;" class="flot-tick-label tickLabel">60</div><div style="position: absolute; top: 115px; left: 7px; text-align: right;" class="flot-tick-label tickLabel">70</div><div style="position: absolute; top: 96px; left: 7px; text-align: right;" class="flot-tick-label tickLabel">80</div><div style="position: absolute; top: 77px; left: 7px; text-align: right;" class="flot-tick-label tickLabel">90</div><div style="position: absolute; top: 58px; left: 1px; text-align: right;" class="flot-tick-label tickLabel">100</div><div style="position: absolute; top: 38px; left: 1px; text-align: right;" class="flot-tick-label tickLabel">110</div><div style="position: absolute; top: 19px; left: 1px; text-align: right;" class="flot-tick-label tickLabel">120</div><div style="position: absolute; top: 0px; left: 1px; text-align: right;" class="flot-tick-label tickLabel">130</div></div></div><canvas class="flot-overlay" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 680px; height: 280px;" width="1360" height="560"></canvas></div>
      </div>

      <div class="col-md-3 bg-white">
        <div class="x_title">
          <h2>Top Campaign Performance</h2>
          <div class="clearfix"></div>
        </div>

        <div class="span12">
          <div>
            <p>Facebook Campaign</p>
            <div class="">
              <div class="progress progress_sm" style="width: 76%;">
                <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="80" style="width: 80%;" aria-valuenow="78"></div>
              </div>
            </div>
          </div>
          <div>
            <p>Twitter Campaign</p>
            <div class="">
              <div class="progress progress_sm" style="width: 76%;">
                <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="60" style="width: 60%;" aria-valuenow="58"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="span12">
          <div>
            <p>Conventional Media</p>
            <div class="">
              <div class="progress progress_sm" style="width: 76%;">
                <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="40" style="width: 40%;" aria-valuenow="38"></div>
              </div>
            </div>
          </div>
          <div>
            <p>Bill boards</p>
            <div class="">
              <div class="progress progress_sm" style="width: 76%;">
                <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50" style="width: 50%;" aria-valuenow="49"></div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="clearfix"></div>
    </div>
  </div>

</div>
