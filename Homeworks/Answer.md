# Feature Envy

#BAD

class Rectangle
  attr_reader :width, :height
  def initialize width = nil, height = nil
    @width = width
    @height = height
  end
end

rect = Rectangle.new 2, 3
perimeter = rect.width * rect.height


#GOOD

class Rectangle
  def initialize width = nil, height = nil
    @width = width
    @height = height
  end

  def perimeter
    @width * @height
  end
end


rect = Rectangle.new 2, 3
perimeter = rect.perimeter




# Message Chains

class Rectangle
  def initialize width = nil, height = nil
    @width = width
    @height = height
  end

  def perimeter
    @width * @height
  end
end

#BAD
rect = Rectangle.new 2, 3
rect.perimeter.blank?


# GOOD

class Rectangle
  def initialize width = nil, height = nil
    @width = width
    @height = height
  end

  def perimeter
    @width * @height
  end

  def perimerter_blank?
    perimeter.blank?
  end
end

rect.perimerter_blank?


#Large class

#BAD

class staff
  def initialize staff_name, position, company_address, company_name
    @staff_name = staff_name
    @position = position
    @company_name = company_name
    @company_address = company_address
  end

  def infomation_staff
    @staff_name + "," + @position
  end

  def infomation_company
    @company_name + "," + company_address
  end
end

#GOOD (Use Extract Class)

class staff
  def initialize staff_name, position
    @staff_name = staff_name
    @position = position
  end

  def infomation_staff
    @staff_name + "," + @position
  end
end

class company
  def initialize company_address, company_name
    @company_name = company_name
    @company_address = company_address
  end

  def infomation_company
    @company_name + "," + company_address
  end
end


#Long parameter list
#BAD

class student_life
  attr_accessor :exam_point, :frequent_point, :cc_point

  def back_to_school
    final_point = @exam_point * 0.7 + @cc_point * 0.2 + @frequent_point * 0.1
    if exam_point < 4
      puts "You win"
    else
      if final_point < 4
        puts "You win"
      else
        puts "You lose"
      end
    end
  end
end


#GOOD

class student_life
  attr_accessor :exam_point, :frequent_point, :cc_point

  def calculate_final_point
    @exam_point * 0.7 + @cc_point * 0.2 + @frequent_point * 0.1
  end

  def back_to_school
    if @exam_point < 4 || calculate_final_point < 4
      puts "You win"
    else
      puts "You lose"
    end
  end
end


# Switch-statements
# Bad

class Area
   attr_accessor :name, :a 
   
   def initialize
     @name = name
     @a = a
   end

   def circle_area
      a * a * 3,14
   end

   def rectangle_area
      a * a
   end

   def cal_area
      case @name
      when "circle"
	circle_area
      when "rectangle"
	rectangle_area
      else
	"can not calculate the area"
      end
   end
end


# GOOD
class Area
   attr_accessor :a
   
   def initialize
       @a = a
   end

   def cal_area
      raise "SYSTEM ERROR: method missing"
   end
end

class Circle < Area
   def cal_area
     a * a * 3,14
   end
end

class Rectangle < Area
   def cal_area
     a * a
   end
end

# Alternative Classes with Different Interfaces
# BAD

class Person
   def learn
	# do_something
   end
   
   def go
       # go with two legs
   end
end

class Elephant
   def eat
	# eat plant
   end

   def run
	# go with four legs
   end
end

# GOOD
class Animal
    def move
	raise "You need override this function"
    end
end

class Person < Animal
   def learn
	# do_something
   end

   def move
	# go with two legs
   end
end

class Elephant < Animal
   def eat
	# eat plant
   end

   def move
	# go with four legs
   end
end

