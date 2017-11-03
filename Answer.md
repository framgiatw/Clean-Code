

# Example:
class User
  attr_accessor :name, :email, :phonenumber, :type, :activated
  has_one :profile
  has_many :articles

  def get_user_information
    puts "Name: " + self.name
    puts "Phonenumber: " + self.phonenumber
  end

  def activated_user
    User.where(activated: true)
  end

  def get_user_type
    user.type
  end

  def create_new_user(name, email, phonenumber, type = 'developer', activated = false)
    user = User.new
    user.name = params[:user][:name],
    user.email = params[:user][:email],
    user.phonenumber: params[:user][:phonenumber],
    user.type = params[:user][:type]
    user.activated = params[:user][:activated]
    if user.save
      render json: {
        name: user.name,
        phonenumber: user.phonenumber,
        email: user.email
      }, status: 200
    else
      render json: {
        message: "There has been an error while trying to create user"
      }, status: 402
    end
  end


  def edit_user(name, email, phonenumber)
    user = User.find_by(id: params[:id])
    user.email = email
    user.name = name
    user.phonenumber = phonenumber
    if user.save
      render json: {
        name: user.name
        phonenumber: user.phonenumber
        email: user.email
      }, status: 200
    else
      render json: {
        message: "There has been an error while trying to create user"
      }, status: 402
    end
  end
end
# 1. The "User" class is too large, it is not only responsible for displaying
# user data, but also responsible for creating a new user and editing user.
# We should use "Extract Class" to make this class smaller
# (User controller for example)
# 2. The method "create_new_user" uses too many parameter. The parameters
# should be extract into another method call or parameter object,
# using rails's built in helper called strong parameter
# 3. The methods create_new_user and edit_user are too long,
# (more than 10 lines). We can refactor these methods by using
# the "Extract methods" technique, by seperating method calls inside
# each main method and encapsulate them in private
# 4. The parameter "name", "email", "method" appears many time accross
# the method create_new_user and edit_user, making this a "Data clump" smell.
# Fix this simply by using strong parameters as above

# Fix:
class User
    attr_accessor :name, :email, :phonenumber, :type, :activated
  has_one :profile
  has_many :articles

  def get_user_information
    puts "Name: " + self.name
    puts "Phonenumber: " + self.phonenumber
  end

  def activated_user
    User.where(activated: true)
  end

  def get_user_type
    user.type
  end
end

class UserController
  def create_new_user
    user = User.new(user_params)
    user.save ? response_user_data : response_fail
  end

  def edit_user
    user = User.find_by(id: params[:id])
    user.update_attributes(user_params) ? render_user_data : response_fail
  end

  private

  def user_params
    params.require(:user).permit(:name, :phonenumber, :email, :type, :activated)
  end

  def assign_user_attributes args

  end

  def render_user_data user
    render json: {
      name: user.name
      phonenumber: user.phonenumber
      email: user.email
    }, status: 200
  end

  def response_fail
    render json: {
      message: "There has been an error while trying to create user"
    }, status: 402
  end
end

#Example:

class Manager
  def edit_user user
    user.update_attributes(user_params)
  end

  def delete_user user
    user.destroy
  end
end

class Admin < Manager
end

class Moderator < Manager
end

# 5. The class moderator here can not have access to the method "delete_user"
# because only admin can delete an user. So this is "Refused Bequest" smell and
# it can be fixed by delegating only the method used to moderator class
# After that, only the "edit_user" method can be used for Moderator

class Moderator < Manager
  def_delegators :edit_user
end


#Example:

class CreatePicture < ActiveRecord::Migration[5.0]
  def change
    create_table :pictures do |t|
      t.string :name
      t.string :description
      t.color :string

      t.timestamps
    end
  end
end

# 6. This is an example of code smell "Primitive Obssession",
# as using the String data type to store color code in hexadecimal
# can be dangerous because string input is not validated,
# such as "324UFA" or "FF3FF3FF2" are not valid hexadecimal color code.

# Fix:
class Picture
  has_one :color
end

class Color
  belongs_to :picture

  attr_reader :code

  def initialize(code)
    @code = validate(code)
  end

  def to_s
    @code.to_s
  end

  private

  def validate(code)
    raise "Invalid color code" unless code =~ /[0-9A-Fa-f]{6}/
    code
  end
end


# Example:
class Article
  attr_accessor :vote, :view_count, :share_count
  belongs_to :user
end

class User
  has_many :articles

  def popularity
    count = 0
    self.articles.each do |article|
      count += article.vote + article.view_count + article.share_count
    end

    count
  end
end

# 7. This example smells of "Feature Envy". The "User" class has method "popularity" to determine
# popularity based on all articles statistics. But inside "User" class the data from "Article" class
# is called too many times

#Fix:

class Article
  belongs_to :user
  attr_accessor :vote, :view_count, :share_count

  def article_popularity
    vote + view_count + share_count
  end
end

class User
  has_many :articles
  def popularity
    count = 0
    self.articles.each do
      count += articles.article_popularity
    end
    count
  end
end


