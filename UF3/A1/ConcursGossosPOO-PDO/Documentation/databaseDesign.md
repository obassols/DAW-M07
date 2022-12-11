-AdminUsers
    -name (PrimaryKey)
    -password

-Fase:
    -id (PrimaryKey)
    -dateStart
    -dateEnd

-Dog:
    -idDog (PrimaryKey)
    -name
    -img
    -owner
    -breed

-Fase_Dog: 
    -idDog (PrimaryKey)(ForeignKey)
    -faseId (PrimaryKey)(ForeignKey)
    -active

-Vote:
    -idSession (PrimaryKey)
    -faseId (PrimaryKey)(ForeignKey)
    -idDog (ForeignKey)