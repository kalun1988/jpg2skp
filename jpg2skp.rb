require 'sketchup.rb'
require 'app_safe_shutdown.rb'
require 'csv'
# Show the Ruby Console at startup so we can
# see any programming errors we may make.
SKETCHUP_CONSOLE.show


def main
	# csv = CSV.read(File.path(File.dirname(__FILE__)+"/jpg2skp/jackie.txt"), headers:true)
	csv = CSV.read(File.path("/Applications/AMPPS/www/lightcover/images/jackie.txt"), headers:true)
	arr= csv.to_a

	# Creates lots of boxes using components 
	ent = Sketchup.active_model.entities 
	s = 10
	w = 10 
	n = 127 
	group = ent.add_group 
	face = group.entities.add_face [0,0,0],[w,0,0],[w,w,0],[0,w,0] 
	face.pushpull -w 
	comp = group.to_component 
	(0..n).each { |i| 
		(0..n).each { |j| 
				z=arr[i][j].to_i*30/255
				transformation = Geom::Transformation.new([i*s,j*s,z]) 
				ent.add_instance(comp.definition, transformation)
		}
	}
end

def model_save(sfile) 
    sfile2 = sfile 
    bret = Sketchup.active_model.save(sfile2) 
    return(bret) if !bret 
end 



# UI.menu("Plugins").add_item("JPG2SKP") {
  main()
  model_save("test123")
  # Sketchup::app_safe_shutdown()
# }