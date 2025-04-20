

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Examples - jQuery Bootgrid</title>
        <meta charset="utf-8">
<meta name="robots" content="index, follow">
<meta name="author" content="Rafael Staib">
<meta name="description" content="Nice, sleek and intuitive. A grid control especially designed for bootstrap.">
<meta name="keywords" content="jQuery, Bootstrap, Bootstrap Table, Plugin, UI, Grid, Table, Bootgrid, HTML5, 
    JavaScript, Accessibility, Grid Control, Data Table">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="google-site-verification" content="pkmVWtqtNRr28clfI4il8kERP1yzE2cDift5RcNBDGs" />

<!-- Required for Open Graph -->
<meta property="og:title" content="jQuery Bootgrid">
<meta property="og:description" content="Nice, sleek and intuitive. A grid control especially designed for bootstrap.">
<meta property="og:type" content="website">
<meta property="og:url" content="http://www.jquery-bootgrid.com">
<meta property="og:image" content="http://www.jquery-bootgrid.com/Content/images/social.png">

<!-- Required for Twitter -->
<meta property="twitter:card" content="summary">
<meta name="twitter:creator" content="@RafaelStaib">
<meta property="twitter:title" content="jQuery Bootgrid">
<meta name="twitter:description" content="Nice, sleek and intuitive. A grid control especially designed for bootstrap.">
<meta name="twitter:image" content="http://www.jquery-bootgrid.com/Content/images/social.png">

<meta name="application-name" content="jQuery Bootgrid" />
<meta name="msapplication-tooltip" content="jQuery Bootgrid" />

<link rel="shortcut icon" href="/icon.png">
<!--link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png"-->
        
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="/Scripts/html5shiv?v=M-FeYbBScGLqubVcAZDu6KZsLoZ2X6cIGHdyjLqxrew1"></script>

<![endif]-->
        
<style>
    @-webkit-viewport { width: device-width; }
    @-moz-viewport { width: device-width; }
    @-ms-viewport { width: device-width; }
    @-o-viewport { width: device-width; }
    @viewport { width: device-width; }
</style>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet" type="text/css">
<link href="/Content/Examples?v=YSNOkDShCb3bpvciR3iRJovn4Q2v2kP6Ju1IrXz7EwE1" rel="stylesheet"/>

<script type="text/javascript">
    // Application Insights
    window.appInsights=window.appInsights||function(ai){
        function f(t){ai[t]=function(){var i=arguments;ai.queue.push(function(){ai[t].apply(ai,i)})}}
        var t=document,r="script",u=t.createElement(r),i;for(u.src=ai.url||"//az416426.vo.msecnd.net/scripts/a/ai.0.js",t.getElementsByTagName(r)[0].parentNode.appendChild(u),ai.cookie=t.cookie,ai.queue=[],i=["Event","Exception","Metric","PageView","Trace"];i.length;)f("track"+i.pop());
        return ai;
    }({
        iKey:"20abbe01-4a2e-431a-b830-226f2a34bca7"
    });

    appInsights.trackPageView();
</script>
        
    <link rel="prev" title="Getting Started with jQuery Bootgrid" href="http://www.jquery-bootgrid.com/GettingStarted">
    <link rel="next" title="Documentation for jQuery Bootgrid" href="http://www.jquery-bootgrid.com/Documentation">

    </head>
    <body data-spy="scroll" data-target="#lefthand" data-offset="60">
        <a name="top"></a>

        <div id="topbar" class="navbar navbar-fixed-top">
            <div class="navbar-inner container">
                <h1>
                    <a href="/">jQuery Bootgrid</a>
                </h1>

                <nav role="navigation">
                    <ul class="nav navbar-nav">
                        <li class=""><a href="/GettingStarted">Getting Started</a></li>
                        <li class=""><a href="/Examples">Examples</a></li>
                        <li class=""><a href="/Documentation">Documentation</a></li>
                        <li><a href="http://www.jquery-steps.com">Steps <span class="label label-danger">Plugin</span></a></li>
                        <li><a href="http://www.rafaelstaib.com">Blog</a></li>
                        <li><a href="https://github.com/rstaib/jquery-bootgrid"><span class="fa fa-github"></span> GitHub</a></li>
                        <li class=""><a href="/About">About</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        
        <div class="sitewrapper container">
            
    <header id="banner" role="banner">
        <h1>Examples</h1>
        <p>See how beautiful jQuery Bootgrid is and what you can do with it!</p>
        <div id="carbonads-container">
    <script async type="text/javascript" src="//cdn.carbonads.com/carbon.js?zoneid=1673&serve=C6AILKT&placement=jquerybootgrid" id="_carbonads_js"></script>
</div>
    </header>

            <div class="socialbar clearfix">
    <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.jquery-bootgrid.com" data-text="jquery bootgrid" data-via="RafaelStaib" data-hashtags="jquerybootgrid">Tweet</a>
    <script>!function (d, s, id) { var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https'; if (!d.getElementById(id)) { js = d.createElement(s); js.id = id; js.src = p + '://platform.twitter.com/widgets.js'; fjs.parentNode.insertBefore(js, fjs); } }(document, 'script', 'twitter-wjs');</script>
    <div class="fb-like" data-href="http://www.jquery-bootgrid.com" data-send="false" data-layout="button_count" data-width="110" data-show-faces="false" data-font="arial"></div>
    <script>(function (d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1"; fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'facebook-jssdk'));</script>
    <div class="g-plusone" data-size="medium" data-href="http://www.jquery-bootgrid.com"></div>
    <script>(function () { var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true; po.src = 'https://apis.google.com/js/plusone.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s); })();</script>
    <iframe src="/github-btn.html?user=rstaib&repo=jquery-bootgrid&type=watch&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="110" height="20"></iframe>
    <iframe src="/github-btn.html?user=rstaib&repo=jquery-bootgrid&type=fork&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="110" height="20"></iframe>
</div>
            



<div class="content">
    <div class="row">
        <nav id="lefthand" class="col-sm-3" role="navigation">
            <ul id="lefthand-nav" class="nav nav-list">
                <li><a href="#basic">Basic Example</a></li>
                <li><a href="#data">Data Example</a></li>
                <li>
                    <a href="#selection">Selection Example</a>
                    <ul class="nav">
                        <li><a href="#basic-selection">Basic Selection</a></li>
                        <li><a href="#keep-selection">Keep Selection</a></li>
                    </ul>
                </li>
                <li><a href="#data-api">Data API Example</a></li>
                <li><a href="#command-buttons">Command Buttons</a></li>
                <li><a href="#more">More Examples</a></li>
            </ul>
        </nav>
        <div class="col-sm-9 main" role="main">
            <section id="basic">
                <h2 class="page-header">Basic Example</h2>
                <p class="lead">It's just that simple. Turn your simple table into a sophisticated data table and offer your users a nice experience and great features without any effort.</p>
                <p><button id="init-basic" type="button" class="btn btn-lg btn-primary">Prettify Table</button></p>
                <table id="grid-basic" class="table table-condensed table-hover table-striped">
                    <thead>
                        <tr>
                            <th data-column-id="id" data-type="numeric">ID</th>
                            <th data-column-id="sender">Sender</th>
                            <th data-column-id="received" data-order="desc">Received</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>10238</td>
                            <td>eduardo@pingpong.com</td>
                            <td>14.10.2013</td>
                        </tr>
                        <tr>
                            <td>10243</td>
                            <td>eduardo@pingpong.com</td>
                            <td>19.10.2013</td>
                        </tr>
                        <tr>
                            <td>10248</td>
                            <td>eduardo@pingpong.com</td>
                            <td>24.10.2013</td>
                        </tr>
                        <tr>
                            <td>10253</td>
                            <td>eduardo@pingpong.com</td>
                            <td>29.10.2013</td>
                        </tr>
                        <tr>
                            <td>10234</td>
                            <td>lila@google.com</td>
                            <td>10.10.2013</td>
                        </tr>
                        <tr>
                            <td>10239</td>
                            <td>lila@google.com</td>
                            <td>15.10.2013</td>
                        </tr>
                        <tr>
                            <td>10244</td>
                            <td>lila@google.com</td>
                            <td>20.10.2013</td>
                        </tr>
                        <tr>
                            <td>10249</td>
                            <td>lila@google.com</td>
                            <td>25.10.2013</td>
                        </tr>
                        <tr>
                            <td>10237</td>
                            <td>robert@bingo.com</td>
                            <td>13.10.2013</td>
                        </tr>
                        <tr>
                            <td>10242</td>
                            <td>robert@bingo.com</td>
                            <td>18.10.2013</td>
                        </tr>
                        <tr>
                            <td>10247</td>
                            <td>robert@bingo.com</td>
                            <td>23.10.2013</td>
                        </tr>
                        <tr>
                            <td>10252</td>
                            <td>robert@bingo.com</td>
                            <td>28.10.2013</td>
                        </tr>
                        <tr>
                            <td>10236</td>
                            <td>simon@yahoo.com</td>
                            <td>12.10.2013</td>
                        </tr>
                        <tr>
                            <td>10241</td>
                            <td>simon@yahoo.com</td>
                            <td>17.10.2013</td>
                        </tr>
                        <tr>
                            <td>10246</td>
                            <td>simon@yahoo.com</td>
                            <td>22.10.2013</td>
                        </tr>
                        <tr>
                            <td>10251</td>
                            <td>simon@yahoo.com</td>
                            <td>27.10.2013</td>
                        </tr>
                        <tr>
                            <td>10235</td>
                            <td>tim@microsoft.com</td>
                            <td>11.10.2013</td>
                        </tr>
                        <tr>
                            <td>10240</td>
                            <td>tim@microsoft.com</td>
                            <td>16.10.2013</td>
                        </tr>
                        <tr>
                            <td>10245</td>
                            <td>tim@microsoft.com</td>
                            <td>21.10.2013</td>
                        </tr>
                        <tr>
                            <td>10250</td>
                            <td>tim@microsoft.com</td>
                            <td>26.10.2013</td>
                        </tr>
                    </tbody>
                </table>
                <h3>Code</h3>
                <div id="steps-basic">
                    <h4>HTML</h4>
                    <section>
                        <pre class="prettyprint linenums">
&lt;table id="grid-basic" class="table table-condensed table-hover table-striped"&gt;
    &lt;thead&gt;
        &lt;tr&gt;
            &lt;th data-column-id="id" data-type="numeric"&gt;ID&lt;/th&gt;
            &lt;th data-column-id="sender"&gt;Sender&lt;/th&gt;
            &lt;th data-column-id="received" data-order="desc"&gt;Received&lt;/th&gt;
        &lt;/tr&gt;
    &lt;/thead&gt;
    &lt;tbody&gt;
        &lt;tr&gt;
            &lt;td&gt;10238&lt;/td&gt;
            &lt;td&gt;eduardo@pingpong.com&lt;/td&gt;
            &lt;td&gt;14.10.2013&lt;/td&gt;
        &lt;/tr&gt;
        ...
    &lt;/tbody&gt;
&lt;/table&gt;</pre>
                    </section>

                    <h4>JavaScript</h4>
                    <section>
                        <pre class="prettyprint linenums">
$("#grid-basic").bootgrid();</pre>
                    </section>
                </div>
            </section>
            <section id="data">
                <h2 class="page-header">Data Example</h2>
                <p><button id="init-data" type="button" class="btn btn-lg btn-primary">Start Example</button></p>
                <table id="grid-data" class="table table-condensed table-hover table-striped">
                    <thead>
                        <tr>
                            <th data-column-id="id" data-type="numeric">ID</th>
                            <th data-column-id="sender">Sender</th>
                            <th data-column-id="received" data-order="desc">Received</th>
                            <th data-column-id="link" data-formatter="link" data-sortable="false">Link</th>
                        </tr>
                    </thead>
                </table>
                <h3>Code</h3>
                <div id="steps-data">
                    <h4>HTML</h4>
                    <section>
                        <pre class="prettyprint linenums">
&lt;table id="grid-data" class="table table-condensed table-hover table-striped"&gt;
    &lt;thead&gt;
        &lt;tr&gt;
            &lt;th data-column-id="id" data-type="numeric"&gt;ID&lt;/th&gt;
            &lt;th data-column-id="sender"&gt;Sender&lt;/th&gt;
            &lt;th data-column-id="received" data-order="desc"&gt;Received&lt;/th&gt;
            &lt;th data-column-id="link" data-formatter="link" data-sortable="false"&gt;Link&lt;/th&gt;
        &lt;/tr&gt;
    &lt;/thead&gt;
&lt;/table&gt;</pre>
                    </section>

                    <h4>JavaScript</h4>
                    <section>
                        <pre class="prettyprint linenums">
$("#grid-data").bootgrid({
    ajax: true,
    post: function ()
    {
        /* To accumulate custom parameter with the request object */
        return {
            id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
        };
    },
    url: "/api/data/basic",
    formatters: {
        "link": function(column, row)
        {
            return "&lt;a href=\"#\"&gt;" + column.id + ": " + row.id + "&lt;/a&gt;";
        }
    }
});</pre>
                    </section>

                    <h4>POST Body (Request)</h4>
                    <section>
                        <pre class="prettyprint linenums">
current=1&rowCount=10&sort[sender]=asc&searchPhrase=&id=b0df282a-0d67-40e5-8558-c9e93b7befed</pre>
                    </section>

                    <h4>JSON (Response)</h4>
                    <section>
                        <pre class="prettyprint linenums">
{
  "current": 1,
  "rowCount": 10,
  "rows": [
    {
      "id": 19,
      "sender": "123@test.de",
      "received": "2014-05-30T22:15:00"
    },
    {
      "id": 14,
      "sender": "123@test.de",
      "received": "2014-05-30T20:15:00"
    },
    ...
  ],
  "total": 1123
}</pre>
                    </section>
                </div>
            </section>
            <section id="selection">
                <h2 class="page-header">Selection Examples</h2>
                <section id="basic-selection">
                    <h3 class="page-header">Basic Selection</h3>
                    <p><button id="init-selection" type="button" class="btn btn-lg btn-primary">Start Example</button></p>
                    <table id="grid-selection" class="table table-condensed table-hover table-striped">
                        <thead>
                            <tr>
                                <th data-column-id="id" data-type="numeric" data-identifier="true">ID</th>
                                <th data-column-id="sender">Sender</th>
                                <th data-column-id="received" data-order="desc">Received</th>
                                <th data-column-id="link" data-formatter="link" data-sortable="false">Link</th>
                            </tr>
                        </thead>
                    </table>
                    <p class="bg-info">Ensure that the data attribute <code>data-identifier="true"</code> is set on one column header.</p>
                    <h3>Code</h3>
                    <div id="steps-selection">
                        <h4>HTML</h4>
                        <section>
                            <pre class="prettyprint linenums">
&lt;table id="grid-selection" class="table table-condensed table-hover table-striped"&gt;
    &lt;thead&gt;
        &lt;tr&gt;
            &lt;th data-column-id="id" data-type="numeric" data-identifier="true"&gt;ID&lt;/th&gt;
            &lt;th data-column-id="sender"&gt;Sender&lt;/th&gt;
            &lt;th data-column-id="received" data-order="desc"&gt;Received&lt;/th&gt;
            &lt;th data-column-id="link" data-formatter="link" data-sortable="false"&gt;Link&lt;/th&gt;
        &lt;/tr&gt;
    &lt;/thead&gt;
&lt;/table&gt;</pre>
                        </section>

                        <h4>JavaScript</h4>
                        <section>
                            <pre class="prettyprint linenums">
$("#grid-selection").bootgrid({
    ajax: true,
    post: function ()
    {
        /* To accumulate custom parameter with the request object */
        return {
            id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
        };
    },
    url: "/api/data/basic",
    selection: true,
    multiSelect: true,
    formatters: {
        "link": function(column, row)
        {
            return "&lt;a href=\"#\"&gt;" + column.id + ": " + row.id + "&lt;/a&gt;";
        }
    }
}).on("selected.rs.jquery.bootgrid", function(e, rows)
{
    var rowIds = [];
    for (var i = 0; i < rows.length; i++)
    {
        rowIds.push(rows[i].id);
    }
    alert("Select: " + rowIds.join(","));
}).on("deselected.rs.jquery.bootgrid", function(e, rows)
{
    var rowIds = [];
    for (var i = 0; i < rows.length; i++)
    {
        rowIds.push(rows[i].id);
    }
    alert("Deselect: " + rowIds.join(","));
});</pre>
                        </section>

                        <h4>POST Body (Request)</h4>
                        <section>
                            <pre class="prettyprint linenums">
current=1&rowCount=10&sort[sender]=asc&searchPhrase=&id=b0df282a-0d67-40e5-8558-c9e93b7befed</pre>
                        </section>

                        <h4>JSON (Response)</h4>
                        <section>
                            <pre class="prettyprint linenums">
{
  "current": 1,
  "rowCount": 10,
  "rows": [
    {
      "id": 19,
      "sender": "123@test.de",
      "received": "2014-05-30T22:15:00"
    },
    {
      "id": 14,
      "sender": "123@test.de",
      "received": "2014-05-30T20:15:00"
    },
    ...
  ],
  "total": 1123
}</pre>
                        </section>
                    </div>
                </section><!--id="basic-selection"-->
                <section id="keep-selection">
                    <h3 class="page-header">Keep Selection</h3>
                    <p><button id="init-keep-selection" type="button" class="btn btn-lg btn-primary">Start Example</button></p>
                    <table id="grid-keep-selection" class="table table-condensed table-hover table-striped">
                        <thead>
                            <tr>
                                <th data-column-id="id" data-type="numeric" data-identifier="true">ID</th>
                                <th data-column-id="sender">Sender</th>
                                <th data-column-id="received" data-order="desc">Received</th>
                                <th data-column-id="link" data-formatter="link" data-sortable="false">Link</th>
                            </tr>
                        </thead>
                    </table>
                    <p class="bg-info">Ensure that the data attribute <code>data-identifier="true"</code> is set on one column header.</p>
                    <h3>Code</h3>
                    <div id="steps-keep-selection">
                        <h4>HTML</h4>
                        <section>
                            <pre class="prettyprint linenums">
&lt;table id="grid-keep-selection" class="table table-condensed table-hover table-striped"&gt;
    &lt;thead&gt;
        &lt;tr&gt;
            &lt;th data-column-id="id" data-type="numeric" data-identifier="true"&gt;ID&lt;/th&gt;
            &lt;th data-column-id="sender"&gt;Sender&lt;/th&gt;
            &lt;th data-column-id="received" data-order="desc"&gt;Received&lt;/th&gt;
            &lt;th data-column-id="link" data-formatter="link" data-sortable="false"&gt;Link&lt;/th&gt;
        &lt;/tr&gt;
    &lt;/thead&gt;
&lt;/table&gt;</pre>
                        </section>

                        <h4>JavaScript</h4>
                        <section>
                            <pre class="prettyprint linenums">
$("#grid-keep-selection").bootgrid({
    ajax: true,
    post: function ()
    {
        /* To accumulate custom parameter with the request object */
        return {
            id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
        };
    },
    url: "/api/data/basic",
    selection: true,
    multiSelect: true,
    rowSelect: true,
    keepSelection: true,
    formatters: {
        "link": function(column, row)
        {
            return "&lt;a href=\"#\"&gt;" + column.id + ": " + row.id + "&lt;/a&gt;";
        }
    }
}).on("selected.rs.jquery.bootgrid", function(e, rows)
{
    var rowIds = [];
    for (var i = 0; i < rows.length; i++)
    {
        rowIds.push(rows[i].id);
    }
    alert("Select: " + rowIds.join(","));
}).on("deselected.rs.jquery.bootgrid", function(e, rows)
{
    var rowIds = [];
    for (var i = 0; i < rows.length; i++)
    {
        rowIds.push(rows[i].id);
    }
    alert("Deselect: " + rowIds.join(","));
});</pre>
                        </section>

                        <h4>POST Body (Request)</h4>
                        <section>
                            <pre class="prettyprint linenums">
current=1&rowCount=10&sort[sender]=asc&searchPhrase=&id=b0df282a-0d67-40e5-8558-c9e93b7befed</pre>
                        </section>

                        <h4>JSON (Response)</h4>
                        <section>
                            <pre class="prettyprint linenums">
{
  "current": 1,
  "rowCount": 10,
  "rows": [
    {
      "id": 19,
      "sender": "123@test.de",
      "received": "2014-05-30T22:15:00"
    },
    {
      "id": 14,
      "sender": "123@test.de",
      "received": "2014-05-30T20:15:00"
    },
    ...
  ],
  "total": 1123
}</pre>
                        </section>
                    </div>
                </section><!--id="keep-selection"-->
            </section><!--id="selection"-->
            <section id="data-api">
                <h2 class="page-header">Data API Example</h2>
                <p class="lead">All setting can be also set via data attributes.</p>
                <table id="grid-data-api" class="table table-condensed table-hover table-striped" data-toggle="bootgrid" data-ajax="true" data-url="/api/data/basic">
                    <thead>
                        <tr>
                            <th data-column-id="id" data-type="numeric" data-identifier="true">ID</th>
                            <th data-column-id="sender">Sender</th>
                            <th data-column-id="received" data-order="desc">Received</th>
                        </tr>
                    </thead>
                </table>
                <h3>Code</h3>
                <div id="steps-selection">
                    <h4>HTML</h4>
                    <section>
                        <pre class="prettyprint linenums">
&lt;table id="grid-data-api" class="table table-condensed table-hover table-striped" data-toggle="bootgrid" data-ajax="true" data-url="/api/data/basic"&gt;
    &lt;thead&gt;
        &lt;tr&gt;
            &lt;th data-column-id="id" data-type="numeric" data-identifier="true"&gt;ID&lt;/th&gt;
            &lt;th data-column-id="sender"&gt;Sender&lt;/th&gt;
            &lt;th data-column-id="received" data-order="desc"&gt;Received&lt;/th&gt;
        &lt;/tr&gt;
    &lt;/thead&gt;
&lt;/table&gt;</pre>
                    </section>

                    <h4>POST Body (Request)</h4>
                    <section>
                        <pre class="prettyprint linenums">
current=1&rowCount=10&sort[sender]=asc&searchPhrase=</pre>
                    </section>

                    <h4>JSON (Response)</h4>
                    <section>
                        <pre class="prettyprint linenums">
{
  "current": 1,
  "rowCount": 10,
  "rows": [
    {
      "id": 19,
      "sender": "123@test.de",
      "received": "2014-05-30T22:15:00"
    },
    {
      "id": 14,
      "sender": "123@test.de",
      "received": "2014-05-30T20:15:00"
    },
    ...
  ],
  "total": 1123
}</pre>
                    </section>
                </div>
            </section>
            <section id="command-buttons">
                <h2 class="page-header">Command Buttons Example</h2>
                <p><button id="init-command-buttons" type="button" class="btn btn-lg btn-primary">Start Example</button></p>
                <table id="grid-command-buttons" class="table table-condensed table-hover table-striped">
                    <thead>
                        <tr>
                            <th data-column-id="id" data-type="numeric">ID</th>
                            <th data-column-id="sender">Sender</th>
                            <th data-column-id="received" data-order="desc">Received</th>
                            <th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
                        </tr>
                    </thead>
                </table>
                <h3>Code</h3>
                <div id="steps-command-buttons">
                    <h4>HTML</h4>
                    <section>
                        <pre class="prettyprint linenums">
&lt;table id="grid-data" class="table table-condensed table-hover table-striped"&gt;
    &lt;thead&gt;
        &lt;tr&gt;
            &lt;th data-column-id="id" data-type="numeric"&gt;ID&lt;/th&gt;
            &lt;th data-column-id="sender"&gt;Sender&lt;/th&gt;
            &lt;th data-column-id="received" data-order="desc"&gt;Received&lt;/th&gt;
            &lt;th data-column-id="commands" data-formatter="commands" data-sortable="false"&gt;Commands&lt;/th&gt;
        &lt;/tr&gt;
    &lt;/thead&gt;
&lt;/table&gt;</pre>
                    </section>

                    <h4>JavaScript</h4>
                    <section>
                        <pre class="prettyprint linenums">
var grid = $("#grid-command-buttons").bootgrid({
    ajax: true,
    post: function ()
    {
        return {
            id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
        };
    },
    url: "/api/data/basic",
    formatters: {
        "commands": function(column, row)
        {
            return "&lt;button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\"&gt;&lt;span class=\"fa fa-pencil\"&gt;&lt;/span&gt;&lt;/button&gt; " + 
                "&lt;button type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.id + "\"&gt;&lt;span class=\"fa fa-trash-o\"&gt;&lt;/span&gt;&lt;/button&gt;";
        }
    }
}).on("loaded.rs.jquery.bootgrid", function()
{
    /* Executes after data is loaded and rendered */
    grid.find(".command-edit").on("click", function(e)
    {
        alert("You pressed edit on row: " + $(this).data("row-id"));
    }).end().find(".command-delete").on("click", function(e)
    {
        alert("You pressed delete on row: " + $(this).data("row-id"));
    });
});</pre>
                    </section>

                    <h4>POST Body (Request)</h4>
                    <section>
                        <pre class="prettyprint linenums">
current=1&rowCount=10&sort[sender]=asc&searchPhrase=&id=b0df282a-0d67-40e5-8558-c9e93b7befed</pre>
                    </section>

                    <h4>JSON (Response)</h4>
                    <section>
                        <pre class="prettyprint linenums">
{
  "current": 1,
  "rowCount": 10,
  "rows": [
    {
      "id": 19,
      "sender": "123@test.de",
      "received": "2014-05-30T22:15:00"
    },
    {
      "id": 14,
      "sender": "123@test.de",
      "received": "2014-05-30T20:15:00"
    },
    ...
  ],
  "total": 1123
}</pre>
                    </section>
                </div>
            </section>
            <section id="more">
                <h2 class="page-header">More Examples</h2>
                <p class="lead">More examples like manipulation will follow very soon. For experienced developer I recommend to see in code how feature-rich and flexible <strong>jQuery Bootgrid</strong> is. Here you see only a small set of features.</p>
            </section>
        </div>
    </div>
</div>


        </div>
        
        <footer id="footer" role="contentinfo">
    <p>&copy; Copyright 2017, <a href="http://www.rafaelstaib.com">Rafael Staib</a></p>
    <ul class="links">
        <li><a href="/Imprint">Impressum</a></li>
        <li class="muted">·</li>
        <li><a href="/Privacy">Datenschutz</a></li>
        <li class="muted">·</li>
        <li><a href="https://github.com/rstaib/jquery-bootgrid/issues"><span class="fa fa-bug"></span> Issues</a></li>
        <li class="muted">·</li>
        <li><a href="https://github.com/rstaib/jquery-bootgrid/releases"><span class="fa fa-flag"></span> Releases</a></li>
    </ul>
</footer>
        
<script>
    if (navigator.userAgent.match(/IEMobile\/10\.0/))
    {
        var msViewportStyle = document.createElement("style");
        msViewportStyle.appendChild(document.createTextNode("@-ms-viewport{width:auto!important}"));
        document.getElementsByTagName("head")[0].appendChild(msViewportStyle);
    }

    // Google Analytics
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-40997516-3', 'jquery-bootgrid.com');
    ga('send', 'pageview');
</script>
<script src="/Scripts/Examples?v=NglZSasDTP7W3VWxa3CtxLT-BD70DFQZ4DvEdOEXfIc1"></script>

        
    <script>
        $(function ()
        {
            $("#lefthand-nav").affix({
                offset: {
                    top: function ()
                    {
                        return $("#topbar").outerHeight() + $("#banner").outerHeight();
                    }
                }
            });

            $("#steps-basic, #steps-data, #steps-selection, #steps-keep-selection, #steps-data-api, #steps-command-buttons").steps({
                headerTag: "h4",
                bodyTag: "section",
                enableFinishButton: false,
                enablePagination: false,
                enableAllSteps: true,
                titleTemplate: "#title#",
                cssClass: "tabcontrol"
            });

            prettyPrint();

            $("#init-basic").one("click", function(e)
            {
                e.stopPropagation();
                $(this).remove();
                $("#grid-basic").bootgrid();
            });

            $("#init-data").one("click", function(e)
            {
                e.stopPropagation();
                $(this).remove();
                $("#grid-data").bootgrid({
                    ajax: true,
                    post: function ()
                    {
                        return {
                            id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
                        };
                    },
                    url: "/api/data/basic",
                    formatters: {
                        "link": function(column, row)
                        {
                            return "<a href=\"#\">" + column.id + ": " + row.id + "</a>";
                        }
                    }
                });
            });

            $("#init-selection").one("click", function(e)
            {
                e.stopPropagation();
                $(this).remove();
                $("#grid-selection").bootgrid({
                    ajax: true,
                    post: function ()
                    {
                        return {
                            id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
                        };
                    },
                    url: "/api/data/basic",
                    selection: true,
                    multiSelect: true,
                    formatters: {
                        "link": function(column, row)
                        {
                            return "<a href=\"#\">" + column.id + ": " + row.id + "</a>";
                        }
                    }
                }).on("selected.rs.jquery.bootgrid", function(e, rows)
                {
                    var rowIds = [];
                    for (var i = 0; i < rows.length; i++)
                    {
                        rowIds.push(rows[i].id);
                    }
                    alert("Select: " + rowIds.join(","));
                }).on("deselected.rs.jquery.bootgrid", function(e, rows)
                {
                    var rowIds = [];
                    for (var i = 0; i < rows.length; i++)
                    {
                        rowIds.push(rows[i].id);
                    }
                    alert("Deselect: " + rowIds.join(","));
                });
            });

            $("#init-keep-selection").one("click", function(e)
            {
                e.stopPropagation();
                $(this).remove();
                $("#grid-keep-selection").bootgrid({
                    ajax: true,
                    post: function ()
                    {
                        return {
                            id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
                        };
                    },
                    url: "/api/data/basic",
                    selection: true,
                    multiSelect: true,
                    rowSelect: true,
                    keepSelection: true,
                    formatters: {
                        "link": function(column, row)
                        {
                            return "<a href=\"#\">" + column.id + ": " + row.id + "</a>";
                        }
                    }
                }).on("selected.rs.jquery.bootgrid", function(e, rows)
                {
                    var rowIds = [];
                    for (var i = 0; i < rows.length; i++)
                    {
                        rowIds.push(rows[i].id);
                    }
                    alert("Select: " + rowIds.join(","));
                }).on("deselected.rs.jquery.bootgrid", function(e, rows)
                {
                    var rowIds = [];
                    for (var i = 0; i < rows.length; i++)
                    {
                        rowIds.push(rows[i].id);
                    }
                    alert("Deselect: " + rowIds.join(","));
                });
            });

            $("#init-command-buttons").one("click", function(e)
            {
                e.stopPropagation();
                $(this).remove();
                var grid = $("#grid-command-buttons").bootgrid({
                    ajax: true,
                    post: function ()
                    {
                        return {
                            id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
                        };
                    },
                    url: "/api/data/basic",
                    formatters: {
                        "commands": function(column, row)
                        {
                            return "<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\"><span class=\"fa fa-pencil\"></span></button> " + 
                                "<button type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.id + "\"><span class=\"fa fa-trash-o\"></span></button>";
                        }
                    }
                }).on("loaded.rs.jquery.bootgrid", function()
                {
                    grid.find(".command-edit").on("click", function(e)
                    {
                        alert("You pressed edit on row: " + $(this).data("row-id"));
                    }).end().find(".command-delete").on("click", function(e)
                    {
                        alert("You pressed delete on row: " + $(this).data("row-id"));
                    });
                });
            });
        });
    </script>

    </body>
</html>