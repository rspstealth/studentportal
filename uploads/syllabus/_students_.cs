using System;
using System.Collections;
using System.Collections.Generic;
using System.Text;
namespace Knh_school
{
    #region Students
    public class Students
    {
        #region Member Variables
        protected unknown _id;
        protected string _admission_number;
        protected string _name;
        protected int _parent_id;
        protected int _relation_type;
        protected string _username;
        protected string _password;
        protected string _gender;
        protected unknown _birthday;
        protected string _religion;
        protected string _blood_group;
        protected string _address;
        protected string _phone;
        protected string _email;
        protected string _class_id;
        protected string _section_id;
        protected string _roll_no;
        protected string _photo_id;
        protected unknown _created_at;
        protected unknown _updated_at;
        #endregion
        #region Constructors
        public Students() { }
        public Students(string admission_number, string name, int parent_id, int relation_type, string username, string password, string gender, unknown birthday, string religion, string blood_group, string address, string phone, string email, string class_id, string section_id, string roll_no, string photo_id, unknown created_at, unknown updated_at)
        {
            this._admission_number=admission_number;
            this._name=name;
            this._parent_id=parent_id;
            this._relation_type=relation_type;
            this._username=username;
            this._password=password;
            this._gender=gender;
            this._birthday=birthday;
            this._religion=religion;
            this._blood_group=blood_group;
            this._address=address;
            this._phone=phone;
            this._email=email;
            this._class_id=class_id;
            this._section_id=section_id;
            this._roll_no=roll_no;
            this._photo_id=photo_id;
            this._created_at=created_at;
            this._updated_at=updated_at;
        }
        #endregion
        #region Public Properties
        public virtual unknown Id
        {
            get {return _id;}
            set {_id=value;}
        }
        public virtual string Admission_number
        {
            get {return _admission_number;}
            set {_admission_number=value;}
        }
        public virtual string Name
        {
            get {return _name;}
            set {_name=value;}
        }
        public virtual int Parent_id
        {
            get {return _parent_id;}
            set {_parent_id=value;}
        }
        public virtual int Relation_type
        {
            get {return _relation_type;}
            set {_relation_type=value;}
        }
        public virtual string Username
        {
            get {return _username;}
            set {_username=value;}
        }
        public virtual string Password
        {
            get {return _password;}
            set {_password=value;}
        }
        public virtual string Gender
        {
            get {return _gender;}
            set {_gender=value;}
        }
        public virtual unknown Birthday
        {
            get {return _birthday;}
            set {_birthday=value;}
        }
        public virtual string Religion
        {
            get {return _religion;}
            set {_religion=value;}
        }
        public virtual string Blood_group
        {
            get {return _blood_group;}
            set {_blood_group=value;}
        }
        public virtual string Address
        {
            get {return _address;}
            set {_address=value;}
        }
        public virtual string Phone
        {
            get {return _phone;}
            set {_phone=value;}
        }
        public virtual string Email
        {
            get {return _email;}
            set {_email=value;}
        }
        public virtual string Class_id
        {
            get {return _class_id;}
            set {_class_id=value;}
        }
        public virtual string Section_id
        {
            get {return _section_id;}
            set {_section_id=value;}
        }
        public virtual string Roll_no
        {
            get {return _roll_no;}
            set {_roll_no=value;}
        }
        public virtual string Photo_id
        {
            get {return _photo_id;}
            set {_photo_id=value;}
        }
        public virtual unknown Created_at
        {
            get {return _created_at;}
            set {_created_at=value;}
        }
        public virtual unknown Updated_at
        {
            get {return _updated_at;}
            set {_updated_at=value;}
        }
        #endregion
    }
    #endregion
}