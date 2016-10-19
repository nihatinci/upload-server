<?php

use yii\db\Migration;

class m161016_230124_users extends Migration
{

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
      $this->createSecretQuestions();
      $this->createCountriesTable();
      $this->createStates();
      $this->createLocationTypesTable();
      $this->createLocationsTable();
      $this->createUsersTable();

    }

    public function safeDown()
    {
    }

      public function createSecretQuestions()
      {
        $sql = "
                  CREATE TABLE IF NOT EXISTS SecretQuestions
                  (
                    id bigint NOT NULL AUTO_INCREMENT,
                    question varchar(256) NOT NULL,
                    CONSTRAINT secret_questions_pkey PRIMARY KEY (id)
                  )
                  ";
        $this->execute($sql);
        $sql = "
                  INSERT INTO SecretQuestions (question) VALUES
                  ( 'What is my favorite movie?' ),
                  ( 'What is my favorite sports team?' ),
                  ( 'What is the name of the street I grew up on?' ),
                  ( 'What is my Mother''s maiden name?' ),
                  ( 'What is my favorite pet''s name?' ),
                  ( 'What is my birthday (mm/dd/yyyy)?' ),
                  ( 'What city was I born in?' )

                  ";
        $this->execute($sql);

      }

    public function createCountriesTable()
    {
      $sql = "
              CREATE TABLE IF NOT EXISTS Countries
              (
                id bigint NOT NULL AUTO_INCREMENT,
                country varchar(256) NOT NULL,
                CONSTRAINT countries_pkey PRIMARY KEY (id)
              )
              ";
      $this->execute($sql);
      $sql = "
              INSERT INTO Countries (country) VALUES ('United States'), ('Canada');
              ";
      $this->execute($sql);

    }

    public function createStates()
    {
      $sql = "
              CREATE TABLE IF NOT EXISTS States
              (
                id bigint NOT NULL AUTO_INCREMENT,
                stateShort varchar(256) NOT NULL,
                state varchar(256) NOT NULL,
                countryId bigint NOT NULL,
                CONSTRAINT states_pkey PRIMARY KEY (id),
                FOREIGN KEY (countryId) REFERENCES Countries(id)
              )
              ";
      $this->execute($sql);
      $sql = "
              INSERT INTO States (stateShort, state, countryId) VALUES
              ('AK', 'Alaska', 1 ),
              ('AL', 'Alabama', 1 ),
              ('AR', 'Arkansas', 1 ),
              ('AZ', 'Arizona', 1 ),
              ('CA', 'California', 1 ),
              ('CO', 'Colorado', 1 ),
              ('CT', 'Connecticut', 1 ),
              ('DC', 'District of Columbia', 1 ),
              ('DE', 'Delaware', 1 ),
              ('FL', 'Florida', 1 ),
              ('GA', 'Georgia', 1 ),
              ('HA', 'Hawaii', 1 ),
              ('IA', 'Iowa', 1 ),
              ('ID', 'Idaho', 1 ),
              ('IL', 'Illinois', 1 ),
              ('IN', 'Indiana', 1 ),
              ('KS', 'Kansas', 1 ),
              ('KY', 'Kentucky', 1 ),
              ('LA', 'Louisiana', 1 ),
              ('MA', 'Massachusetts', 1 ),
              ('MD', 'Maryland', 1 ),
              ('ME', 'Maine', 1 ),
              ('MI', 'Michigan', 1 ),
              ('MN', 'Minnesota', 1 ),
              ('MO', 'Missouri', 1 ),
              ('MS', 'Mississippi', 1 ),
              ('MT', 'Montana', 1 ),
              ('NC', 'North Carolina', 1 ),
              ('ND', 'North Dakota', 1 ),
              ('NE', 'Nebraska', 1 ),
              ('NH', 'New Hampshire', 1 ),
              ('NJ', 'New Jersey', 1 ),
              ('NM', 'New Mexico', 1 ),
              ('NV', 'Nevada', 1 ),
              ('NY', 'New York', 1 ),
              ('OH', 'Ohio', 1 ),
              ('OK', 'Oklahoma', 1 ),
              ('OR', 'Oregon', 1 ),
              ('PA', 'Pennsylvania', 1 ),
              ('PR', 'Puerto Rico', 1 ),
              ('RI', 'Rhode Island', 1 ),
              ('SC', 'South Carolina', 1 ),
              ('SD', 'South Dakota', 1 ),
              ('TN', 'Tennessee', 1 ),
              ('TX', 'Texas', 1 ),
              ('UT', 'Utah', 1 ),
              ('VA', 'Virginia', 1 ),
              ('VI', 'Virgin Islands', 1 ),
              ('VT', 'Vermont', 1 ),
              ('WA', 'Washington', 1 ),
              ('WI', 'Wisconsin', 1 ),
              ('WV', 'West Virginia', 1 ),
              ('WY', 'Wyoming', 1 ),
              ('AT', 'Alberta', 2),
              ('BR', 'British Columbia', 2),
              ('MB', 'Manitoba', 2),
              ('NB', 'New Brunswick', 2),
              ('NL', 'Newfoundland and Labrador', 2),
              ('NT', 'Northwest Territories', 2),
              ('NS', 'Nova Scotia', 2),
              ('NU', 'Nunavut', 2),
              ('ON', 'Ontario', 2),
              ('PE', 'Prince Edward Island', 2),
              ('QU', 'Quebec', 2),
              ('SA', 'Saskatchewan', 2),
              ('YU', 'Yukon', 2)
              ";
      $this->execute($sql);

    }

    public function createLocationTypesTable()
    {
      $sql = "
            CREATE TABLE IF NOT EXISTS LocationTypes
            (
              id bigint NOT NULL AUTO_INCREMENT,
              locationType varchar(256) NOT NULL,
              CONSTRAINT location_types_pkey PRIMARY KEY (id)
            )
            ";
      $this->execute($sql);
      $sql = "
            INSERT INTO LocationTypes (locationType) VALUES ('Billing'), ('Shipping'), ('Other');
            ";
      $this->execute($sql);

    }

    public function createLocationsTable()
    {
      $sql = "
          CREATE TABLE IF NOT EXISTS Locations
          (
            id bigint NOT NULL AUTO_INCREMENT,
            locationName varchar(256),
            address1 varchar(256) NOT NULL,
            address2 varchar(256),
            city varchar(256) NOT NULL,
            stateId bigint NOT NULL,
            zip varchar(256) NOT NULL,
            locationTypeId bigint NOT NULL,
            CONSTRAINT users_pkey PRIMARY KEY (id),
            FOREIGN KEY (stateId) REFERENCES States(id),
            FOREIGN KEY (locationTypeId) REFERENCES LocationTypes(id)
          )
          ";
      $this->execute($sql);
    }

    public function createUsersTable()
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS Users
        (
          id bigint NOT NULL AUTO_INCREMENT,
          username varchar(256) NOT NULL,
          password varchar(256) NOT NULL,
          email varchar(256) NOT NULL,
          firstName varchar(256) NOT NULL,
          lastName varchar(256) NOT NULL,
          title varchar(256),
          companyName varchar(256) NOT NULL,
          phone varchar(256) NOT NULL,
          alternatePhone varchar(256),
          fax varchar(256),
          secretQuestionId bigint NOT NULL,
          secretAnswer varchar(256) NOT NULL,
          locationId bigint NOT NULL,
          CONSTRAINT users_pkey PRIMARY KEY (id),
          CONSTRAINT users_unique UNIQUE(username),
          FOREIGN KEY (locationId) REFERENCES Locations(id),
          FOREIGN KEY (secretQuestionId) REFERENCES SecretQuestions(id)
        )
        ";
        $this->execute($sql);
    }

}
