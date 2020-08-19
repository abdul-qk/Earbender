  <div class="container">
      <div class="row">
          <div class="col-md-12">
              <input type="hidden" id="sortType" value="ASC" />
          </div>
      </div>

      <div class="row mt-5 mb-3">
          <div class="col-md-7">
              <h1 class="d-inline">My Contacts</h1>
              <button style="margin-bottom: 10px" class="btn follow_btn btn-top add-btn">Add Contact</button>
              <i class="far icon_cancel d-none fa-times-circle"></i>
          </div>
          <div style="margin-top: 10px" class="col-md-5">
              <button class="btn follow_btn btn-top active" id="SortAZ">A to Z</button>
              <button class="btn follow_btn btn-top" id="SortZA">Z to A</button>
              <button class="btn follow_btn btn-top" id="exportXml">Export ContactList</button>
          </div>
      </div>
      <div class="search-list" class="form-group" style="background: none; border: 1px #fff; border-radius: 20px;">
          <input style="width: 83.5%; margin-right: 10px; border: 1px solid #000" type="text" name="search_contact" id="search_profile" placeholder="Search by Tag or Surname">
          <button class="search-contact" style="background: #fff; border: none; cursor: pointer; margin-bottom: 20px; border: 1px solid #000; padding: 10px 20px; border-radius: 20px" id="search-contact">Search</button>
          <i style="font-size: 22px;; padding-left: 10px" class="fas fa-sync-alt refresh"></i>
      </div>
      <table style="border: 1px solid; border-top: 3px solid;" class="table">
          <thead>
              <tr>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Number</th>
                  <th>Tags</th>
                  <th colspan="2"></th>
              </tr>
              <tr class="add-form d-none">
                  <td>
                      <div class="form-group">
                          <input type="text" class="form-control fname-input" required>
                      </div>
                  </td>
                  <td>
                      <div class="form-group">
                          <input class="form-control lname-input" required>
                      </div>
                  </td>
                  <td>
                      <div class="form-group">
                          <input class="form-control email-input" required>
                      </div>
                  </td>
                  <td>
                      <div class="form-group">
                          <input class="form-control number-input" required>
                      </div>
                  </td>
                  <td><select multiple data-style="bg-white rounded-pill px-4 py-3 shadow-sm" id="tags-input" name="genre[]" class="selectpicker w-100" required>
                          <option value="1">Family</option>
                          <option value="2">Friends</option>
                          <option value="3">Work</option>
                      </select>
                  </td>
                  <td colspan="2"><button class="btn btn-primary add-contact">Add</button></td>
              </tr>
          </thead>
          <tbody class="all-contacts"></tbody>
      </table>
  </div>

  <script type="text/template" class="all-contacts-template">
      <td><span class="fname"><%= fname %></span></td>
        <td><span class="lname"><%= lname %></span></td>
        <td><span class="email"><%= email %></span></td>
        <td><span class="number"><%= number %></span></td>
        <td><span class="tags"><%= tagsArray.tags %></span></td>
        <td colspan="2">
            <button class="btn btn-primary edit"><i class="far fa-edit"></i></button>
            <button class="btn btn-danger delete-modal" data-toggle="modal" data-target="#myModal"><i class="far fa-trash-alt"></i></button>
            <button class="btn btn-danger delete remote d-none"><i class="far fa-trash-alt"></i></button>
            <button class="btn btn-success update" style="display:none"><i class="fas fa-user-edit"></i></button>
            <button class="btn btn-danger cancel-edit" style="display:none"><i class="far fa-window-close"></i></button>
        </td>
  </script>
  <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title">Are you sure?</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
              <div class="modal-body">
                  <p>Do you really want to delete this contact info? This process cannot be undone.</p>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                  <button type="button" class="btn btn-danger delete-it" data-dismiss="modal">Delete</button>
              </div>
          </div>
      </div>
  </div>
  <script>
      Backbone.Model.prototype.idAttribute = 'contact_id';

      /** Contact BACKBONE!! */

      var Contact = Backbone.Model.extend({
          defaults: {
              fname: '',
              lname: '',
              email: '',
              number: '',
              tags: '',
          }
      });

      // Backbone Collection

      var Contacts = Backbone.Collection.extend({
          url: '<?php echo base_url(); ?>index.php/Contacts/contact'
      });

      // instantiate a Collection

      var contacts = new Contacts();

      // Backbone View for one blog

      var ContactView = Backbone.View.extend({
          model: new Contact(),
          tagName: 'tr',
          initialize: function() {
              this.template = _.template($('.all-contacts-template').html());
          },
          events: {
              'click .edit': 'editContact',
              'click .update': 'updateContact',
              'click .cancel-edit': 'cancelEdit',
              'click .delete': 'deleteContact'
          },

          editContact: function() {
              $('.edit').hide();
              $('.delete-modal').hide();
              this.$('.update').show();
              this.$('.cancel-edit').show();


              var fname = this.$('.fname').html();
              var lname = this.$('.lname').html();
              var email = this.$('.email').html();
              var number = this.$('.number').html();
              var tags = this.$('.tags').html();

              this.$('.fname').html('<input type="text" class="form-control fname-update" value="' + fname + '">');
              this.$('.lname').html('<input type="text" class="form-control lname-update" value="' + lname + '">');
              this.$('.email').html('<input type="text" class="form-control email-update" value="' + email + '">');
              this.$('.number').html('<input type="text" class="form-control number-update" value="' + number + '">');

          },

          updateContact: function() {
              this.model.set('fname', $('.fname-update').val());
              this.model.set('lname', $('.lname-update').val());
              this.model.set('email', $('.email-update').val());
              this.model.set('number', $('.number-update').val());

              // ****** Specify update url. ****** //
              this.model.set('url', "<?php echo base_url(); ?>index.php/Contacts/contact");

              this.model.save(null, { // This is POST method.
                  success: function(response) {
                      console.log('Contact was updated, id: ' + response.toJSON().contact_id);
                  },
                  error: function(err) {
                      console.log('Contact was not updated.');
                  }
              });
          },
          cancelEdit: function() {
              contactsView.render();
          },
          deleteContact: function() {
              this.model.destroy({
                  success: function(response) {
                      console.log('Contact was deleted, id: ' + response.toJSON().contact_id);
                  },
                  error: function(err) {
                      console.log('Contact was not deleted.');
                  }
              });
          },
          render: function() {
              this.$el.html(this.template(this.model.toJSON()));
              return this;
          }
      });

      // Backbone View for all the Contacts
      var ContactsView = Backbone.View.extend({
          model: contacts,
          el: $('.all-contacts'),
          initialize: function() {
              var self = this;
              this.model.on('add', this.render, this);
              this.model.on('update', this.render, this);
              this.model.on('change', function() {
                  setTimeout(function() {
                      self.render();
                  }, 30);
              }, this);
              this.model.on('remove', this.render, this);

              this.model.fetch({
                  data: $.param({
                      sortType: $("#sortType").val()
                  }),
                  success: function(response) {
                      _.each(response.toJSON(), function(item) {
                          console.log('Contact was displayed, id: ' + item.contact_id);
                      })
                  },
                  error: function() {
                      console.log('Contact was not viewed.');
                  }
              });
          },
          render: function() {
              var self = this;
              this.$el.html('');
              _.each(this.model.toArray(), function(blog) {
                  self.$el.append((new ContactView({
                      model: blog
                  })).render().$el);
              });
              return this;
          }
      });

      var contactsView = new ContactsView();

      /** END --- Contact BACKBONE!! */


      /** Searching BACKBONE!! */

      var Search = Backbone.Model.extend({
          defaults: {
              searchTerm: ''
          }
      });

      var Searchs = Backbone.Collection.extend({
          url: '<?php echo base_url(); ?>index.php/Contacts/search'
      });

      var searchs = new Searchs();

      var SearchView = Backbone.View.extend({
          model: searchs,
          el: $('.all-contacts'),
          initialize: function() {
              var self = this;
              this.model.on('add', this.render, this);
              this.model.on('update', this.render, this);
              this.model.on('change', function() {
                  setTimeout(function() {
                      self.render();
                  }, 30);
              }, this);
              this.model.on('remove', this.render, this);
              this.model.fetch({
                  data: $.param({
                      search_contact: $("#search_profile").val()
                  }),
                  success: function(response) {
                      _.each(response.toJSON(), function(item) {
                          console.log('Contact was found, id: ' + item.contact_id);
                          console.log(item);
                      })
                  },
                  error: function() {
                      console.log('Contact was not found');
                  }
              });

          },
          render: function() {
              var self = this;
              this.$el.html('');
              _.each(this.model.toArray(), function(blog) {
                  if (blog.attributes.hasOwnProperty('contact_id')) {
                      self.$el.append((new ContactView({
                          model: blog
                      })).render().$el);
                  }
              });
              return this;
          }
      });



      /** END --- Searching BACKBONE!! */

      $(document).ready(function() {
          $(".delete-it").click(function() {
              $('.remote').click();
          });

          $(".add-btn").click(function() {
              $('.add-form').removeClass('d-none');
              $('.icon_cancel').removeClass('d-none');
          });

          $(".icon_cancel").click(function() {
              $('.add-form').addClass('d-none');
              $('.icon_cancel').addClass('d-none');
          });

          $("#SortAZ").click(function() {
              $('#SortAZ').addClass('active');
              $('#SortZA').removeClass('active');
          });

          $("#SortZA").click(function() {
              $('#SortZA').addClass('active');
              $('#SortAZ').removeClass('active');
          });

          $("#search-contact").click(function() {
              var searchView = new SearchView();
          });

          $("#SortZA").click(function() {
              $("#sortType").val('DESC');
              var contactsView = new ContactsView();
          });

          $("#SortAZ").click(function() {
              $("#sortType").val('ASC');
              var contactsView = new ContactsView();
          });

          $('.refresh').click(function() {
              $("#sortType").val('ASC');
              var contactsView = new ContactsView();
              $('#search_profile').val("");
          })

          $("#exportXml").click(function() {
              $.get(
                  '<?php echo base_url(); ?>index.php/Contacts/exportExcel',

                  function(data, textStatus, jqXHR) { // success callback
                      document.write('<a href="data:application/octet-stream;base64;charset=utf-8,' + btoa(data) + '">Click to save to file</a>');
                  });
          });

          $('.add-contact').on('click', function() {
              const tags = ['', 'Family', 'Friends', 'Work'];
              let setArray = [];
              const selectedWork = $('#tags-input').val()
              for (i = 0; i < selectedWork.length; i++) {
                  setArray[i] = tags[selectedWork[i]];
              }
              var contact = new Contact({
                  fname: $('.fname-input').val(),
                  lname: $('.lname-input').val(),
                  email: $('.email-input').val(),
                  number: $('.number-input').val(),
                  tagsArray: {
                      tags: setArray
                  },
                  tags: selectedWork.toString(),
                  url: "<?php echo base_url(); ?>index.php/Contacts/contact"
              });
              $('.fname-input').val('');
              $('.lname-input').val('');
              $('.email-input').val('');
              $('.number-input').val('');
              $('#tags-input').val([]);
              contacts.add(contact);
              contact.save(null, {
                  success: function(response) {
                      $('.add-form').addClass('d-none');
                      $('.icon_cancel').addClass('d-none');
                      console.log('Contact was saved to DB, id: ' + response.toJSON().contact_id);
                  },
                  error: function(err) {
                      console.log('Contact could not be saved.');
                  }
              });
          });
      })
  </script>