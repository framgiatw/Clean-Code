#Clean-code
#1
#smell code example (Duplicate Method)
class student
  def checkpoint point
    if point.max < 3
      puts "week"
    else point.max >= 5
      puts "normal"
    end
  end
end
#refactor
class student
  def checkpoint point
      max_point = point.max
    if max_point < 3
      puts "week"
    else max_point >= 5
      puts "normal"
    end
  end
end
#2
#smell code example( If ___ Return True, Else Return False)
class Animal
  attr_reader :type

  def initialize type
    @type = type
  end

  def is_a_dog?
    if @type == "dog"
      return true
    else
      return false
    end
  end
end
#refactor
class Animal
  attr_reader :type

  def initialize type
    @type = type
  end

  def is_a_dog?
    @type == "dog"
  end
end
#3

class Language
  def speak name
    case name
    when "english"
      puts "hello, english"
    when "chinese"
      puts "hello, chinese"
    when "Vietnam"
      puts "xin chao, Viet Nam"
    else
      puts "i dont know"
    end
  end
end
#refactor

class Language
  def speak name
    language = Hash.new "i dont know"
    language["english"] = "hello, english"
    language["chinese"] = "hello, chinese"
    language["Vietnam"] = "xin chao, Viet Nam"

    puts language[name]
  end
end

#4

class Person
  attr_reader :department

  def initialize department
    @department = department
  end
end

class Department
  attr_reader :manager

  def initialize manager
    @manager = manager
  end
end

Khi muốn biết manager của person ta bắt buộc phải lấy qua department trước:
manager = john.department.manager
Code smell: Message Chains

#Refactor: sử dụng Hide Delegate
class Person
  extend Forwardable
  attr_reader :department

  def initialize department
    @department = department
  end

  def_delegator :@department, :manager
end

class Department
  attr_reader :manager

  def initialize manager
    @manager = manager
  end
end


#5
class Dog
  attr_reader :name

  def initialize name
    @name = name
  end

  def self.find_and_make_sound name
    dog = Dogs.find{|dog| dog.name == name}
    dog.make_sound if dog
  end

  def make_sound
    puts "bark"
  end
end

Dogs = [Dog.new("Bo"), Dog.new("Max")]
Dog.find_and_make_sound("Bo") // => "bark"
Dog.find_and_make_sound("Mac") // => nothing

#Refactor: sử dụng Introduce Null Object

class Dog
  attr_reader :name

  def initialize name
    @name = name
  end

  def self.find_and_make_sound name
    dog = Dogs.find{|dog| dog.name == name} || NilAnimal.new
    dog.make_sound
  end

  def make_sound
    puts "bark"
  end
end

class NilAnimal
  def make_sound
  end
end

Dogs = [Dog.new("Bo"), Dog.new("Max")]
Dog.find_and_make_sound("Bo") // => "bark"
Dog.find_and_make_sound("Mac") // => nothing



