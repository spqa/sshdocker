@extends('layouts.master1')
@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="middle-content" style="width: 100% !important;">
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l4">
                    <div class="card stats-card">
                        <div class="card-content">
                            <div class="card-options">
                                {{--<ul>--}}
                                    {{--<li class="red-text"><span class="badge cyan lighten-1">gross</span></li>--}}
                                {{--</ul>--}}
                            </div>
                            <span class="card-title">Số VPS</span>
                            <span class="stats-counter"><span class="counter">{{\App\Vps::count()}}</span><small>vps</small></span>
                        </div>
                        <div id="sparkline-bar"></div>
                    </div>
                </div>
                <div class="col s12 m12 l4">
                    <div class="card stats-card">
                        <div class="card-content">
                            <div class="card-options">
                            </div>
                            <span class="card-title">Số Website</span>
                            <span class="stats-counter"><span class="counter">{{\App\Server::count()}}</span><small>website(s)</small></span>
                        </div>
                        <div id="sparkline-line"></div>
                    </div>
                </div>
                <div class="col s12 m12 l4">
                    <div class="card stats-card">
                        <div class="card-content">
                            <span class="card-title">Reports</span>
                            <span class="stats-counter"><span class="counter">0</span><small>Last week</small></span>
                            <div class="percent-info green-text">0% <i class="material-icons">trending_up</i></div>
                        </div>
                        <div class="progress stats-card-progress">
                            <div class="determinate" style="width: 70%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l8">
                    <div class="card visitors-card">
                        <div class="card-content">
                            <div class="card-options">
                                <ul>
                                    <li><a href="javascript:void(0)" class="card-refresh"><i class="material-icons">refresh</i></a></li>
                                </ul>
                            </div>
                            <span class="card-title">Visitors<span class="secondary-title">Showing stats from the last week</span></span>
                            <div id="flotchart1"></div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12 l4">
                    <div class="card server-card">
                        <div class="card-content">
                            <div class="card-options">
                                <ul>
                                    <li class="red-text"><span class="badge blue-grey lighten-3">optimal</span></li>
                                </ul>
                            </div>
                            <span class="card-title">Server Load</span>
                            <div class="server-load row">
                                <div class="server-stat col s4">
                                    <p>167GB</p>
                                    <span>Usage</span>
                                </div>
                                <div class="server-stat col s4">
                                    <p>320GB</p>
                                    <span>Space</span>
                                </div>
                                <div class="server-stat col s4">
                                    <p>57.4%</p>
                                    <span>CPU</span>
                                </div>
                            </div>
                            <div class="stats-info">
                                <ul>
                                    <li>Google Chrome<div class="percent-info green-text right">32% <i class="material-icons">trending_up</i></div></li>
                                    <li>Safari<div class="percent-info red-text right">20% <i class="material-icons">trending_down</i></div></li>
                                    <li>Mozilla Firefox<div class="percent-info green-text right">18% <i class="material-icons">trending_up</i></div></li>
                                </ul>
                            </div>
                            <div id="flotchart2"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12">
                    <div class="card invoices-card">
                        <div class="card-content">
                            <div class="card-options">
                                <input type="text" class="expand-search" placeholder="Search" autocomplete="off">
                            </div>
                            <span class="card-title">Invoices</span>
                            <table class="responsive-table bordered">
                                <thead>
                                <tr>
                                    <th data-field="id">ID</th>
                                    <th data-field="number">Payment Type</th>
                                    <th data-field="company">Company</th>
                                    <th data-field="date">Date</th>
                                    <th data-field="progress">Progress</th>
                                    <th data-field="total">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>#203</td>
                                    <td>PayPal</td>
                                    <td>Curabitur Libero Corp</td>
                                    <td>Dec 16, 18:12</td>
                                    <td><span class="pie">3/8</span></td>
                                    <td>$5430</td>
                                </tr>
                                <tr>
                                    <td>#202</td>
                                    <td>American Express</td>
                                    <td>Integer Mattis Ltd</td>
                                    <td>Nov 29, 13:56</td>
                                    <td><span class="pie">5/8</span></td>
                                    <td>$1400</td>
                                </tr>
                                <tr>
                                    <td>#200</td>
                                    <td>Discover</td>
                                    <td>Pellentesque Inc</td>
                                    <td>Nov 17, 19:14</td>
                                    <td><span class="pie">3/8</span></td>
                                    <td>$1250</td>
                                </tr>
                                <tr>
                                    <td>#199</td>
                                    <td>MasterCard</td>
                                    <td>Curabitur Libero Corp</td>
                                    <td>Oct 21, 12:16</td>
                                    <td><span class="pie">5/8</span></td>
                                    <td>$1349</td>
                                </tr>
                                <tr>
                                    <td>#198</td>
                                    <td>Amex</td>
                                    <td>Integer Mattis Ltd</td>
                                    <td>Oct 14, 22:43</td>
                                    <td><span class="pie">3/8</span></td>
                                    <td>$980</td>
                                </tr>
                                <tr>
                                    <td>#197</td>
                                    <td>PayPal</td>
                                    <td>Pellentesque Inc</td>
                                    <td>Sept 29, 10:33</td>
                                    <td><span class="pie">5/8</span></td>
                                    <td>$679</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @endsection