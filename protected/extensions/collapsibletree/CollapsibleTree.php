<?php

/**
 * CollapsibleTree class file.
 *
 * PHP Version 5.1
 * 
 * @package  Widget
 * @author   FBurhan <sefburhan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     http://www.yiiframework.com/user/62626/
 */
class CollapsibleTree extends CWidget {
    /**
     * @var array of data for tree with many levels as per applications demands,
     */
    public $data =null;  
    /**
     * @var string for css .
     */
    public $cssFile;
    /**
     * @var string for javascript  .
     */
    public $jsFile;
    /**
     * @var string for height of container  .
     */
    public $height = 960;
    /**
     * @var string for width of container .
     */
    public $width = 800;
    /**
     * @var string for margin top to containter  .
     */
    public $marginTop = 20;
    /**
     * @var string for margin bottom to containter .
     */
    public $marginBottom = 20;
    /**
     * @var string for margin right to containter .
     */
    public $marginRight = 120;
    /**
     * @var string for margin left to containter .
     */
    public $marginLeft = 120;
    /**
     * @var string for tree duration on collapse and expand .
     */
    public $duration = 750;
   
/**
     * @var string for circle radius duration on collapse and expand .
     */
    public $cradius = 7.5;
    
    
    /**
     * @var string for circle radius duration on collapse and expand .
     */
 
    public function init() {

 
        $path = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.collapsibletree.assets', -1, false));

        $this->jsFile = $path . '/library.js';
        $this->cssFile = $path . '/css.css';

        $cs = Yii::app()->clientScript;

        $cs->registerScriptFile($this->jsFile);
        $cs->registerCssFile($this->cssFile);
 
        $script = '
       (function($) {
            var margin = {top: "' . $this->marginTop . '", right: "' . $this->marginRight . '", bottom: "' . $this->marginBottom . '", left: "' . $this->marginLeft . '"},
            width = "' . $this->width . '" - margin.right - margin.left,
            height = "' . $this->height . '" - margin.top - margin.bottom;
          
            var i = 0,duration = ' . $this->duration . ', root;
            var tree = d3.layout.tree().size([height, width]);
            var diagonal = d3.svg.diagonal().projection(function(d) { return [d.y, d.x]; });
            var svg = d3.select("#collapsibleTree").append("svg")
                        .attr("width","' . $this->width . '")
                        .attr("height", "' . $this->height . '")
                        .append("g").attr("transform", "translate(" + margin.left + "," + margin.top + ")");
  
            root =' . json_encode($this->data) . ';
            root.x0 = height / 2;
            root.y0 = 0;

            function collapse(d) {
              if (d.children) {
                d._children = d.children;
                d._children.forEach(collapse);
                d.children = null;
              }
            }

            root.children.forEach(collapse);
            update(root);
            d3.select(self.frameElement).style("height", "' . $this->height . '");

                function update(source) {

                  var nodes = tree.nodes(root).reverse(),
                  links = tree.links(nodes);
                  nodes.forEach(function(d) { d.y = d.depth * 180; });

                  var node = svg.selectAll("g.node").data(nodes, function(d) { return d.id || (d.id = ++i); });

                  // Enter any new nodes at the parents previous position.
                  var nodeEnter = node.enter().append("g").attr("class", "node").attr("transform", function(d) { return "translate(" + source.y0 + "," + source.x0 + ")"; }).on("click", click);

                  nodeEnter.append("circle").attr("r", 1e-6).style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; });

                  nodeEnter.append("text").attr("x", function(d) { return d.children || d._children ? -10 : 10; })
                           .attr("dy", ".35em").attr("text-anchor", function(d) { return d.children || d._children ? "end" : "start"; })
                           .text(function(d) { return d.name; }).style("fill-opacity", 1e-6);

                  // Transition nodes to their new position.
                  var nodeUpdate = node.transition().duration(duration).attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; });

                  nodeUpdate.select("circle").attr("r","' . $this->cradius . '").style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; });

                  nodeUpdate.select("text").style("fill-opacity", 1);

                  // Transition exiting nodes to the parents new position.
                  var nodeExit = node.exit().transition().duration(duration).attr("transform", function(d) { return "translate(" + source.y + "," + source.x + ")"; }).remove();

                  nodeExit.select("circle").attr("r", 1e-6);
                  nodeExit.select("text").style("fill-opacity", 1e-6);
                  // Update the links…
                  var link = svg.selectAll("path.link").data(links, function(d) { return d.target.id; });

                  // Enter any new links at the parents previous position.
                  link.enter().insert("path", "g").attr("class", "link").attr("d", function(d) { var o = {x: source.x0, y: source.y0};
                        return diagonal({source: o, target: o});});

                  // Transition links to their new position.
                  link.transition().duration(duration).attr("d", diagonal);

                  // Transition exiting nodes to the parents new position.
                  link.exit().transition().duration(duration).attr("d", function(d) {
                        var o = {x: source.x, y: source.y};
                        return diagonal({source: o, target: o});
                      }).remove();

                  // Stash the old positions for transition.
                  nodes.forEach(function(d) {
                    d.x0 = d.x;
                    d.y0 = d.y;
                  });
                }
                function click(d) {
                  if (d.children) {
                    d._children = d.children;
                    d.children = null;
                  } else {
                    d.children = d._children;
                    d._children = null;
                  }
                  update(d);
             }})(jQuery);';
        
        $cs->registerScript('collapsibletree', $script);
    }

    /**
     * Run this widget.
     * This method registers necessary javascript and renders the needed HTML code.
     */
    public function run() {
     
        echo '<div id="collapsibleTree"></div>';
    }

}
?>
