// Dimensions of sunburst.
var width = 750;
var height = 600;
var radius = Math.min(width, height) / 2;

// Breadcrumb dimensions: width, height, spacing, width of tip/tail.
var b = {
  w: 75, h: 30, s: 3, t: 10
};

// Mapping of step names to colors.
var colors = {
  "Elite Daily": "#5687d1",
  "YouTube": "#7b615c",
  "BuzzFeed": "#de783b",
  "io9": "#6ab975"
};
// "humor": "#a173d1",
// "dating": "#bbbbbb",
// "life": "#bfd041",
// "money": "#60c1db",
// "celebrity": "#fd95b3"

var color_rand = [
  "#5687d1",
  "#7b615c",
  "#de783b",
  "#6ab975",
  "#a173d1",
  "#bbbbbb",
  "#bfd041",
  "#60c1db",
  "#fd95b3"
];

var share_links = {
  "elite daily": "shares/elitedaily.html",
  "io9":         "shares/io9.html",
  "soundcloud":  "shares/soundcloud.html",
  "youtube":     "shares/youtube.html",
  "buzzfeed":    "shares/buzzfeed.html"
};

var share_map = {
  "elite daily":                                                           57,
  "dating":                                                                34,
  "ladies":                                                                14,
  "the 7 types of guys youre bound to meet on tinder":                     3,
  "fearless females 4 tips for taking charge and making the first move":   2,
  "gentlemen":                                                             6,
  "why you should date a girl with short hair":                            2,
  "humor":                                                                 17,
  "clips":                                                                 4,
  "these five moms deserve some serious extra credit on mothers day":      3,
  "its amazing how much binge watching and binge drinking have in common": 1,
  "funny papers":                                                          2,
  "youre doing it wrong the unofficial gen y etiquette guide to texting":  1,
  "life":                                                                  12,
  "generation y":                                                          13,
  "7 things that are worth fighting for if you want a fulfilling life":    3,
  "dear mom a letter of grattitude to all mothers this mothers day":       6,
  "money":                                                                 9,
  "startups":                                                              5,
  "how one girl used her personal struggle to turn a penny into a startup":2,
  "io9":                                                                   19,
  "webcomics":                                                             3,
  "see what your favorite webcomics look like animated":                   3,
  "history":                                                               2,
  "the evolution of special effects from 1878 to today in just 3 minutes": 1,
  "biotechnology":                                                         3,
  "the first lifeform capable of passing down a juiced up form of dna":    2,
  "soundcloud":                                                            12,
  "aviciiofficial":                                                        6,
  "you make me diplo ookay remix":                                         2,
  "wake me up extended mix":                                               1,
  "youngmoneydotcom":                                                      1,
  "believe me ft drake lil wayne":                                         1,
  "youtube":                                                               103,
  "music":                                                                 52,
  "arctic monkeys":                                                        17,
  "r u mine":                                                              3,
  "do i wanna know":                                                       8,
  "trailors":                                                              22,
  "godzilla":                                                              16,
  "official main trailor":                                                 11,
  "nature has an order":                                                   4,
  "buzzfeed":                                                              42,
  "tech":                                                                  8,
  "why twitters newest tweetstorm trend must be stopped":                  2,
  "20 people at techcrunch disrupt on how to fix the tech industry":       4,
  "celebrity":                                                             19,
  "paris hiltons dog house is probably nicer than your own home":          3
}

// Total size of all segments; we set this later, after loading the data.
var totalSize = 0; 

var vis = d3.select("#chart").append("svg:svg")
    .attr("width", width)
    .attr("height", height)
    .append("svg:g")
    .attr("id", "container")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

var partition = d3.layout.partition()
    .size([2 * Math.PI, radius * radius])
    .value(function(d) { return d.size; });

var arc = d3.svg.arc()
    .startAngle(function(d) { return d.x; })
    .endAngle(function(d) { return d.x + d.dx; })
    .innerRadius(function(d) { return Math.sqrt(d.y); })
    .outerRadius(function(d) { return Math.sqrt(d.y + d.dy); });

// Use d3.text and d3.csv.parseRows so that we do not need to have a header
// row, and can receive the csv as an array of arrays.
d3.text("../assets/csv/share-sequences.csv", function(text) {
  var csv = d3.csv.parseRows(text);
  var json = buildHierarchy(csv);
  createVisualization(json);
});

// Main function to draw and set up the visualization, once we have the data.
function createVisualization(json) {

  // Basic setup of page elements.
  // initializeBreadcrumbTrail();
  // drawLegend();
  // d3.select("#togglelegend").on("click", toggleLegend);

  // Bounding circle underneath the sunburst, to make it easier to detect
  // when the mouse leaves the parent g.
  vis.append("svg:circle")
      .attr("r", radius)
      .style("opacity", 0);

  // For efficiency, filter nodes to keep only those large enough to see.
  var nodes = partition.nodes(json)
      .filter(function(d) {
      return (d.dx > 0.005); // 0.005 radians = 0.29 degrees
      });

  var path = vis.data([json]).selectAll("path")
      .data(nodes)
      .enter().append("svg:path")
      .attr("display", function(d) { return d.depth ? null : "none"; })
      .attr("d", arc)
      .attr("fill-rule", "evenodd")
      .style("fill", function(d) { return pick_color(d); }) // colors[d.name]; })
      .style("opacity", 1)
      .on("click", click)
      .on("mouseover", mouseover);

  // Add the mouseleave handler to the bounding circle.
  d3.select("#container").on("mouseleave", mouseleave);

  // Get total size of the tree = value of root node from partition.
  totalSize = path.node().__data__.value;
 };

function pick_color(d) {
  if (d.name in colors)
    return colors[d.name];

  return color_rand[Math.floor((Math.random() * 9))];
}

function click(d) {
  // var url = urlify(d.name.toLowerCase());
  d3.select("#share-data")
      .html(printAncestors(d));
  // window.location = url;
}

var return_url = "";

function urlify(elem) {
  var tmp = elem.name.replace(/[?:_'’(.)]|_/g, "").toLowerCase();
  stripped = tmp.replace(/ /g, "-")
  if (elem.depth == 1)
    return_url = stripped + "/";
  else if (elem.depth == 2)
    return_url += stripped + "/";
  else if (elem.depth == 3)
    return_url += stripped + "/";
  else if (elem.depth == 4)
    return_url += stripped + ".html";
}

function printAncestors(node) {
  var ancestors = getAncestors(node);
  var html = "";
  ancestors.forEach(function(elem) {
    var simplify = elem.name.replace(/[?:_'’(.)]|_/g, "").toLowerCase();
    urlify(elem);
    var net_count = share_map[simplify];
    var ppl = "people";
    if (net_count == 1)
      ppl = "person";
    var percentage = calculatePercentage(elem);
    // html += "<p>\"" + elem.name + "\" makes up " + percentage + " of your shared content.</p>";
    html += "<div class=\"row\"><div class=\"med-12 columns\">"; // Base opening lines
    html += "<p>It looks like <strong>" + net_count + "</strong> " + ppl + " in your network have shared <a href=\""+return_url+"\">" + elem.name + "</a>.</p>";
    html += "</div></div>";
  });
  return html;
}

// Fade all but the current sequence, and show it in the breadcrumb trail.
function mouseover(d) {

  var percentageString = calculatePercentage(d);

  d3.select("#percentage")
      .text(percentageString);

  d3.select("#explanation")
      .style("visibility", "");

  d3.select("#share-source")
      .text(d.name);

  var sequenceArray = getAncestors(d);
  // updateBreadcrumbs(sequenceArray, percentageString);

  // Fade all the segments.
  d3.selectAll("path")
      .style("opacity", 0.3);

  // Then highlight only those that are an ancestor of the current segment.
  vis.selectAll("path")
      .filter(function(node) {
                return (sequenceArray.indexOf(node) >= 0);
              })
      .style("opacity", 1);
}

// Restore everything to full opacity when moving off the visualization.
function mouseleave(d) {

  // Hide the breadcrumb trail
  d3.select("#trail")
      .style("visibility", "hidden");

  // Deactivate all segments during transition.
  d3.selectAll("path").on("mouseover", null);

  // Transition each segment to full opacity and then reactivate it.
  d3.selectAll("path")
      .transition()
      .duration(1000)
      .style("opacity", 1)
      .each("end", function() {
              d3.select(this).on("mouseover", mouseover);
            });

  d3.select("#explanation")
      .transition()
      .duration(1000)
      .style("visibility", "hidden");
}

// Given a node in a partition layout, return an array of all of its ancestor
// nodes, highest first, but excluding the root.
function getAncestors(node) {
  var path = [];
  var current = node;
  while (current.parent) {
    path.unshift(current);
    current = current.parent;
  }
  return path;
}

function calculatePercentage(d) {
  var percentage = (100 * d.value / totalSize).toPrecision(3);
  var percentageString = percentage + "%";
  if (percentage < 0.1) {
    percentageString = "< 0.1%";
  }
  return percentageString;
}

// Take a 2-column CSV and transform it into a hierarchical structure suitable
// for a partition layout. The first column is a sequence of step names, from
// root to leaf, separated by hyphens. The second column is a count of how 
// often that sequence occurred.
function buildHierarchy(csv) {
  var root = {"name": "root", "children": []};
  for (var i = 0; i < csv.length; i++) {
    var sequence = csv[i][0];
    var size = +csv[i][1];
    if (isNaN(size)) { // e.g. if this is a header row
      continue;
    }
    var parts = sequence.split("-");
    var currentNode = root;
    for (var j = 0; j < parts.length; j++) {
      var children = currentNode["children"];
      var nodeName = parts[j];
      var childNode;
      if (j + 1 < parts.length) {
        // Not yet at the end of the sequence; move down the tree.
       	var foundChild = false;
       	for (var k = 0; k < children.length; k++) {
       	  if (children[k]["name"] == nodeName) {
       	    childNode = children[k];
       	    foundChild = true;
       	    break;
       	  }
       	}
        // If we don't already have a child node for this branch, create it.
       	if (!foundChild) {
       	  childNode = {"name": nodeName, "children": []};
       	  children.push(childNode);
       	}
       	currentNode = childNode;
      } else {
       	// Reached the end of the sequence; create a leaf node.
       	childNode = {"name": nodeName, "size": size};
       	children.push(childNode);
      }
    }
  }
  return root;
};