<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PrintTemplate extends Component
{
    public $samples = [];
    protected $listeners = ['printEy' => 'print'];

    public function print()
    {
        dd('erst');
        $data = view('livewire.print-template')->render();

        echo "<script>
            function printOut(data) {
                var mywindow = window.open('', '', 'height=1000,width=1000');
                mywindow.document.write('<html><head>');
                mywindow.document.write('<title></title>');
                mywindow.document.write('<link rel=\"stylesheet\" href=\"".asset('resources/css/app.css')."\" />');
                mywindow.document.write('<style>.print-button { display: none; }</style>'); // Add CSS to hide the button
                mywindow.document.write('</head><body >');
                mywindow.document.write(data);
                mywindow.document.write('</body></html>');

                mywindow.document.close();
                mywindow.focus();
                setTimeout(() => {
                    mywindow.print();
                    return true;
                }, 1000);
            }
            printOut(\"".$data."\");
        </script>";
    }

    public function render()
    {
        return view('livewire.print-component');
    }

}
