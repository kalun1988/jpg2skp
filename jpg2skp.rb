require 'sketchup.rb'
require 'csv'
# Show the Ruby Console at startup so we can
# see any programming errors we may make.
SKETCHUP_CONSOLE.show

# Add a menu item to launch our plugin.
UI.menu("Plugins").add_item("JPG2SKP") {
  # UI.messagebox("I'm about to draw stairs!") 
  # Call our new method.
  main

}

def main
   # Create some variables.
  run = 10
  width = 10
  thickness = 100
  #csv

  # Get handles to our model and the Entities collection it contains.
  model = Sketchup.active_model
  entities = model.entities

	csv = CSV.read(File.path(File.dirname(__FILE__)+"/jpg2skp/jackie.txt"), headers:true)
	arr= csv.to_a
	x_step=1
	arr.each do |sub|
		y_step=1
	  sub.each do |int|

	    # Calculate our stair corners.
	    x1 = run * x_step
	    x2 = run * (x_step + 1)
	    y1 = run * y_step
	    y2 = run * (y_step + 1)
	    z= int.to_i
	    # Create a series of "points", each a 3-item array containing x, y, and z.
	    pt1 = [x1, y1, z]
	    pt2 = [x2, y1, z]
	    pt3 = [x2, y2, z]
	    pt4 = [x1, y2, z]

	    # Call methods on the Entities collection to draw stuff.
	    new_face = entities.add_face pt1, pt2, pt3, pt4
	    new_face.pushpull thickness
	    y_step=y_step+1
	  end
	x_step=x_step+1
	end






end