<?php
require('tpl/generic.tpl.php');
echo $tpltop;

# MENU TOP
echo '<div id="topmenu"><br/>';
echo '<span class="upper_menu_entry"><a class="upper_menu_link" href="index.php">Maps</a></span>';
echo '<span class="upper_menu_entry"><a class="upper_menu_link" href="graphs.php">Graphs</a></span>';
echo '<span class="upper_menu_entry"><a class="upper_menu_link_current" href="faq.php">Help</a></span>';
echo '<br/><br/><hr/></div>';

# MENU LEFT
echo '<div id="leftmenu" class="leftmenu">';;
echo '<h1><a class="aide" href="#pre">Presentation</a></h1>'; 
echo '<h1><a class="aide" href="#glo">Glossary</a></h1>'; 
echo '<h1><a class="aide" href="#gui">Guided Tour</a></h1>'; 
echo '<h1><a class="aide" href="#con">Concepts and Methods</a></h1>'; 
echo '<h1><a class="aide" href="#abo">About the Tool</a></h1>'; 
echo '</div>';


# MAIN CONTENT
echo '<div id="container">';


# Presentation
echo '<h1 id="pre">Presentation</h1><br/>
<p>

The Functional Indicator Tool (FIT) is a practical and user-friendly application for producing and displaying innovative indicators related to Territorial Cohesion Policy at European and regional levels. <br/> <br/>
The FIT uses methods that relies on spatial interaction modeling, it aims to compute functional indicators based on stock indicators processed in a way that take into account the neighborhood of each region.<br/> <br/>
These indicators have four main purposes: <em>to take into account the effect of transportation networks on the territories, to allow comparing regions in Europe, to clarify spatial information blurred by heterogeneous size regions and to reflect the spatial context of indicators values in each region.</em>

</p>';





# Glossary
echo '<br/><h1 id="glo">Glossary</h1><br/>


<h2 id="ind">Indicator</h2>
<p>Three variables are available - <b>Total Population, Active Population and Gross Domestic Product</b>(at current market prices) - and each variable measures the stocks in the EU NUTS. Total Population and GDP variables are available at the NUTS3 level. Active Population is available only at NUTS2 level.
<br/>Data sources: <a class="aide" href="http://database.espon.eu/db2/" target="_BLANK"> ESPON Database</a>.</p>

<br/><h2 id="pot">Potential</h2>
<p><b>Potential</b> and accessibility indicators show the same phenomenon in two distinct ways: time oriented (accessibility) or stock oriented (potential). Potential indicators measure the stocks (stocks of population, of workers, of production) that are located around a place at a distance (time). 
</br>Four potential parameters are available (<b>1 hour, 2 hours, 4 hours, 8 hours</b>): the user may choose a time threshold and get the amount of stocks reachable within this threshold.</p>

<br/><h2 id="bor">Border</h2>
<p>A checkbox is available for the potential indicators allowing to switch on or off the border. If the border effect is switched on, the potential indicators are computed within national boundaries, considering that the national borders represent an impassable obstacle. If the border effect is switched off, the potential indicators are computed without national borders, considering that the national borders represent no obstacle.</p>

<br/><h2 id="acc">Accessibility</h2>
<p><b>Accessibility</b> and potential indicators show the same phenomenon in two distinct ways: time oriented (accessibility) or stock oriented (potential). Accessibility indicators measure the distance (in time) needed to reach an amount of stock (GDP, total population, active population). 
</br>Three accessibility parameters are available (<b>1%, 5%, 10%</b>): the user may choose a percent of the total EU amount of the corresponding variable to be reached (for example, 1% of the total EU population).</p>

<br/><h2 id="mod">Mode</h2>
<p>Four modes of transportation are available - road, rail, air and multimodal - and each mode is associated with a time matrix between NUTS centroids. 
</br>The time matrices by <b>road</b> and <b>rail</b> measure the time needed to reach one NUTS centroid from another one by these modes. 
</br>The time matrix by <b>air</b> measures the time needed to reach one NUTS centroid from another one by air but if road travel time is faster, road travel time is given. 
</br>The <b>multimodal</b> travel time between centroids of NUTS-3 regions is based on logsum of road, rail and air. 
<br/>Data sources: S&W Spiekermann & Wegener, Urban and Regional Research (Output of S&W Accessibility model).
</p>

<br/><h2 id="dat">Date</h2>
<p>The functional indicators are available at three dates - <b>2001, 2006, 2011</b> - which means that the computation take into account the temporal variation of stocks (Total Population, Active Population and GDP) but also the variation of the time matrices.</p>
';

# Guided Tour
echo '<br/><h1 id="gui">Guided Tour</h1><br/> 
<h2>Overall Presentation</h2><br/>
The Functional Indicators Tool is structured with four tabs:
<ul>
<li><p>The <b>Maps</b> tab: this tab displays maps of accessibility and potential indicators. Five boxes are available to set parameters and visualize different indicators. An additional box, called <b>Interpretation Key</b>, gives information to assist the user in interpreting the displayed maps, with key features and a brief explanatory text. This short information box is displayed next to the map and summarizes the parameters used to produce the figure and their meaning regarding the European territorial policy
. The <b>TOP 10</b> table shows the ten regions with the best values of potential or accessibility. Finally, two buttons give the possibility to download the map<sup><a href="#fn1" id="ref1">1</a></sup> and the corresponding data<sup><a href="#fn2" id="ref2">2</a></sup>.</p></li>

<li><p>The <b>My Region</b> tab: this tab displays regional graphs of potential and accessibility to compare the different modes of transportation. It summarizes the main information with regional detail. The first step is to target a region to be analyzed by selecting its country in the first list and then selceting it in the second list. Then all the indicators are displayed in all modes of transport for the selected region.</p></li>

<li><p>The <b>Benchmark</b> tab: this tab displays regional graphs of potential and accessibility to compare different regions. It summarizes the main information with regional detail. The first step is to target a region to be analyzed by selecting its country in the first list and then selecting it in the second list. Then one indicator is displayed in  one modes of transport for the selected region. User can then select and add other regions to the graph</p></li>

<li><p>The <b>Help</b> tab: this tab is composed of five sub-menus - <a class="aide" href="#pre">Presentation</a>, <a class="aide" href="#glo">Glossary</a>, <a class="aide" href="#gui">Guided Tour</a>, <a class="aide" href="#con">Concepts and Methods</a>  and <a class="aide" href="#abo">About the Tool</a> - which give all the meta-information needed to understand and use the FIT application.</p></li>
</ul>



<br/><h2>What time is needed to access to a given amount of resource? <br/>
What amount of resource can be reached within a given time?</h2><br/>



<p>The accessibility indicators answer to the first question whereas potential indicators answer to the second. We present here examples of uses of these indicators:</p>

<p><em>What is the amount of GDP reachable around my region?</em></p>

<blockquote>
<p>By setting the parameters of the <b>Potential box</b>, the user selects the time needed to reach an amount of GDP. For example, in a neighborhood of 2 hour by road around the Inner London - West region, the amount of reachable GDP is 641,040 Millions of euros in 2006 (Value indicated in the <code>Top 10</code> summary).</p>
<p>Another possibility would be to limit the amount of GDP reachable to countries borders by switching off the border effect. It is then possible for users to work at Member states level and access the amount of GDP reachable within each countries of the ESPON area. This border effect is obvious for Luxembourg values for example.</p>
</blockquote>


<p><em>How long would it take to reach a particular amount of the total population?</em></p>
<blockquote>

<p>By setting the parameters of the <b>Accessibility box</b>, the user selects the share of an indicator to be reached. For example, it would take 4 to 5 hours to reach 5% of the active population by air in 2011 in the Athens region whereas it would take only 2 to 3 hours in The Luxembourg region. For this kind of detailed diagnostic, the <b>Benchmark</b> tab may also be useful.</p>
</blockquote>

<p><em>Choosing an optimal location: the EU parliament visitor\'s centers</em></p>
<blockquote>

<p>The European parliament wants to open two European &quot;Parlementariums&quot;: visitors\' centers across Europe to raise its visibility. The centers have to be as close as possible to a minimum number of 5,500,000 of inhabitants (total population). They must be located in capital cities regions, which are far away from London, Brussels, and Paris and can be reached within 2 hours maximum by road in 2011. The European parliament must choose Madrid and Roma regions.</p>
</blockquote>

<p><em>What are the benefits of a full territorial integration? Playing with the border effect</em></p>
<blockquote>
<p>The FIT proposes an interesting parameter called <b>border</b>. By switching on the border effet, the application returns potential values considering that national borders are impassable; by switching off the border effect, the application returns values considering that national borders represent no obstacle to human mobility.</p>
<p>Many obstacles are still at work that reduce the mobility of actors across national borders inside the EU territory. Legal barriers are still active in many fields of activity that limits the opportunity for an individual or a firm to establish in foreign regions or cities. For example, it is well known that cross-border labor markets introduce constraints concerning pensions, social security, taxes. Mental barriers may also be considered as long as many actors can prefer to stay in their own country, all things being equal to the opportunity and the accessibility. The border effect parameter is useful to compare a worst-case scenario (impassable borders) with an optimal scenario (fully integrated European territory). Choose a border region and compare the size of its labor market area switching on and off the border parameter.</p>
</blockquote>
';



# Concepts and Methods
echo '<br/><h1 id="con">Concepts and Methods</h1><br/> 


<p>Accessibility and potentials, as conceived in this application, grasp the same phenomenon by two distinct ways: time oriented (accessibility) or stock oriented (potential). This measure is known in the literature, depending on the discipline, as &quot;potential access&quot;, &quot;gravitational potential&quot; or &quot;gravitational accessibility&quot;. The concept was developped by in the 1940s by physicist John Q. Stewart (1942), from an analogy to the gravity model. In his seminal work on the catchment area of American universities, Stewart computes &quot;potentials of population&quot;. This potential is defined as a stock of population weighted by distance.</p>
<p>The simplest way to measure accessibility is counting the number of opportunities within an predefined area. For a given individual, we may consider that all the stores and services situated within a buffer circle of 1 kilometer around his home place are accessible, farther they are no more accessible. This measure is binary (accessible / not accessible): it isn\'t suited to distinguish specific spatial configurations (<strong>cf. figure 1</strong>). Measured by simple accessibility, the situations 1a and 1b are equivalent: 4 places (stores for example) are accessible. Similarly, the situations 2a et 2b are equivalent to the simple accessibility measure: there is no accessible place within the defined area.</p>
<p><img src="img/Fig1_Accessibilite.png" alt="Figure1" width="50%"></p>
<p><strong>Figure 1</strong></p>




<p>The gravitational accessibility (or potential) is sounder because it weights the places (stores in this example) by the distance (or time) of access. It distinguishes situations <strong>1a</strong> and <strong>1b</strong> by giving more weight to closer stores and less to remote ones. Similarly, it distinguishes situations <strong>2a</strong> et <strong>2b</strong> by weighting the opportunities by the distance of access: an individual with no close-distance opportunities living in an environment full of medium-distance opportunities is in a completely different situation compared to an individual with no close-distance opportunities nor medium-distance ones.</p>
<p>The functional indicators are designed through a spatial interaction function representing the distance friction or impedance. At the very place of the opoortunity, the interaction function equals 1, meaning that the potential access is 100%. Far away from the opportunity, the interaction function tends to 0, meaning that the potential access is 0 %. The &quot;reach&quot; is defined as the value where the interaction function equals 0.5 (50%). From the individuals\' point of vue, this function may be seen as a degree of availability of a given opportunity. From the opportunity\'s point of vue (a store for example), the interaction function may be seen as a decreasing catchment area: there is a maximal attraction close to the opportunity and this attraction decreases progressively through distance.</p>
<p>This example with individuals and stores can be transfered to places and stock variables. The gravitational indicator helps distinguishing (1) the situation of a small city or region situed in a desert area (2) from the situation of a small city or region situated in a densely populated area. For example, the Arr. Bastogne (Belgium, BE342) is a small unit situed in the dense core of the European space whereas the Pinhal Interior (Portugal, PT166) is a small unit situed in a very sparsely populated context.</p>
<p>Two crucial choices have to be taken to calibrate this function: choice of the distribution function and choice of its parameters. Part of this decision is taken by the tool conception team in order to propose a user-friendly application; part of this decision is let to the user so that he/she could adapt the functional indicators to his/her needs.</p>
<p>The two main distribution functions used in spatial interaction models are the power function (pareto) and the exponential function (<strong>cf. figure 2</strong>). In the field of transportation modeling, exponential functions are the most widely used because they fit better to trip length distribution in an urban context (Evans 1970a, 1970b). Power and exponential functions may also be combined for a better fit to empirical data (Ortúzar &amp; Willumsen 2011).</p>
<p><img src="img/Fig2_FrictionDistance.png" alt="Figure1" width="100%"></p>
<p><strong>Figure 2</strong></p>

<p>Transportation modelers calibrate their models with a specific dataset within a specific urban context. In the FIT, we need a versatile solution which may give a decent approximation of spatial interactions in a wide range of contexts and applications. We choose the exponential function: this choice is consistent with the state-of-art in transportation studies, spatial interactions modeling and spatial interpolation approaches (Isaaks &amp; Srivastava 1989, Grasland et al. 2000). The exponent of the function is set to 3, setting a steep decreasing slope.</p>
<h2 id="references">References</h2>
<p>Grasland C., Mathian H., Vincent J.M. (2000) &quot;Multiscalar analysis of map generalisation of discrete social phenomena. Statistical problems and political consequences&quot;, <em>Statistical Journal of the United Nations</em>, 17: 157-188.</p>
<p>Isaaks E.H., Srivastava R.M. (1989) <em>An introduction to applied geostatistics</em>, New York: Oxford University Press.</p>
<p>Ortúzar J.D, Willumsen L.G. (2011) <em>Modelling transport</em>, 4th edition, Chichester: Wiley.</p>
<p>Stewart J. Q. (1942) &quot;Measure of the influence of a population at a distance&quot;, <em>Sociometry</em>, 5(1): 63-71.</p>

';


# About the tool
echo '<br/><h1 id="abo">About the Tool</h1><br/> 
<p>The Functional Indicator Tool has been created in 2014 by <a class="aide" href="http://www.ums-riate.fr/" target="_BLANK">UMS RIATE</a> in the framework of ESPON Tools (2011-2014).</p>
<p>Indicators and maps are computed and displayed thanks to free and open-source softwares: R, Virtualbox, PHP...</p>

<br/><h2>Contacts</h2><br/>
<p>
<b>Timothée Giraud</b> <i>(coordinator & R development)</i>:  <a class="aide" href="mailto:timothee.giraud@ums-riate.fr?subject=[FIT]">timothee.giraud@ums-riate.fr</a><br/>
<b>Hadrien Commenges</b> <i>(R development)</i>:  <a class="aide" href="mailto:hcommenges@parisgeo.cnrs.fr?subject=[FIT]">hcommenges@parisgeo.cnrs.fr</a><br/>
<b>Nicolas Lambert</b> <i>(web development)</i>: <a class="aide" href="mailto:nicolas.lambert@ums-riate.fr?subject=[FIT]">nicolas.lambert@ums-riate.fr</a><br/>
</p>


<hr/>



';



echo '
<sup id="fn1">1. The name of the file contains all the parameters used to create the mapped indicator and can be used as title.<a href="#ref1" title="return to the Guided Tour">↩</a></sup> <br/>
<sup id="fn2">2. The name of the file contains all the parameters used to create the mapped indicator. The file is encoded in UTF-8, which is the standard format used to handle accentuated characters and non-latin alphabets. To open the file in Excel: click the "Data" tab, and in the "Get External Data" panel, click "From Text". Select the file to open. In the Text Import Wizard, select "Delimited", and from the "File origin" drop-down list, select "65001: Unicode (UTF-8)" and click "next". In the "Delimiters" section select "comma" and click "finish". Finally select "New worksheet" and "OK"<a href="#ref2" title="return to the Guided Tour">↩</a></sup>
';
echo '</div>';
echo $tplbottom;
