<?php
  function printDogsInput() {
    require_once('./Classes/Dog.php');
    $dogs = Dog::getDatabaseDogs();
    $htmlString = '';
    foreach ($dogs as $key => $dog) {
      $htmlString .= '<input type="radio" name="poll" onclick="submit()" id="opt-' . $key . '" value="' . $dog['id'] . '">';
      if (isset($_SESSION['vote']) && $_SESSION['vote'] == $dog['name']) {
        $htmlString .= '<label for="opt-' . $key . '" class="selected">';
      } else {
        $htmlString .= '<label for="opt-' . $key . '" class="">';
      }
      $htmlString .=   '<div class="row">
                            <div class="column">
                                <div class="right">
                                    <span class="circle"></span>
                                    <span class="text">' . $dog['name'] . '</span>
                                </div>
                                <img class="dog" alt="' . $dog['name'] . '" src="./img/' . $dog['img'] . '">
                            </div>
                        </div>
                      </label>';
    }
    return $htmlString;
    /* '<input type="radio" name="poll" onclick="submit()" id="opt-1" value="Musclo">
            <label for="opt-1" class="">
                <div class="row">
                    <div class="column">
                        <div class="right">
                            <span class="circle"></span>
                            <span class="text">Musclo</span>
                        </div>
                        <img class="dog" alt="Musclo" src="img/g1.png">
                    </div>
                </div>
            </label>
            <input type="radio" name="poll" onclick="submit()" id="opt-2" value="Jingo" >
            <label for="opt-2" class="">
                <div class="row">
                    <div class="column">
                        <div class="right">
                            <span class="circle"></span>
                            <span class="text">Jingo</span>
                        </div>
                        <img class="dog" alt="Jingo" src="img/g2.png">
                    </div>
                </div>
            </label>
            <input type="radio" name="poll" onclick="submit()" id="opt-3" value="Xuia">
            <label for="opt-3" class="">
                <div class="row">
                    <div class="column">
                        <div class="right">
                            <span class="circle"></span>
                            <span class="text">Xuia</span>
                        </div>
                        <img class="dog" alt="Xuia" src="img/g3.png">
                    </div>
                </div>
            </label>
            <input type="radio" name="poll" onclick="submit()" id="opt-4" value="Bruc">
            <label for="opt-4" class="">
                <div class="row">
                    <div class="column">
                        <div class="right">
                            <span class="circle"></span>
                            <span class="text">Bruc</span>
                        </div>
                        <img class="dog" alt="Bruc" src="img/g4.png">
                    </div>
                </div>
            </label>
            <input type="radio" name="poll" onclick="submit()" id="opt-5" value="Mango">
            <label for="opt-5" class="">
                <div class="row">
                    <div class="column">
                        <div class="right">
                            <span class="circle"></span>
                            <span class="text">Mango</span>
                        </div>
                        <img class="dog" alt="Mango" src="img/g5.png">
                    </div>
                </div>
            </label>
            <input type="radio" name="poll" onclick="submit()" id="opt-6" value="Fluski">
            <label for="opt-6" class="">
                <div class="row">
                    <div class="column">
                        <div class="right">
                            <span class="circle"></span>
                            <span class="text">Fluski</span>
                        </div>
                        <img class="dog" alt="Fluski" src="img/g6.png">
                    </div>
                </div>
            </label>
            <input type="radio" name="poll" onclick="submit()" id="opt-7" value="Fonoll">
            <label for="opt-7" class="">
                <div class="row">
                    <div class="column">
                        <div class="right">
                            <span class="circle"></span>
                            <span class="text">Fonoll</span>
                        </div>
                        <img class="dog" alt="Fonoll" src="img/g7.png">
                    </div>
                </div>
            </label>
            <input type="radio" name="poll" onclick="submit()" id="opt-8" value="Swing">
            <label for="opt-8" class="">
                <div class="row">
                    <div class="column">
                        <div class="right">
                            <span class="circle"></span>
                            <span class="text">Swing</span>
                        </div>
                        <img class="dog" alt="Swing" src="img/g8.png">
                    </div>
                </div>
            </label>
            <input type="radio" name="poll" onclick="submit()" id="opt-9" value="Coloma">
            <label for="opt-9" class="">
                <div class="row">
                    <div class="column">
                        <div class="right">
                            <span class="circle"></span>
                            <span class="text">Coloma</span>
                        </div>
                        <img class="dog" alt="Coloma" src="img/g9.png">
                    </div>
                </div>
            </label>'; */
  }
?>