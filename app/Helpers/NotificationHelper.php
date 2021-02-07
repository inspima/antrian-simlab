<?php

    namespace App\Helpers;

    class NotificationHelper
    {
        private $WA_FORMAT_LINE_BREAK = '
';
        private $WA_FORMAT_BOLD = '*';
        private $WA_FORMAT_ITALIC = '_';

        private function generateMultipleLineWhatsapp($count)
        {
            $result = '';
            for ($i = 1; $i <= $count; $i++) {
                $result .= $this->WA_FORMAT_LINE_BREAK;
            }
            return $result;
        }

        private function formatingMessageWhatsapp($message)
        {
            $message = str_replace('[lb]', $this->WA_FORMAT_LINE_BREAK, $message);
            $header = $this->formattingBoldWhatsapp(getenv('APP_NAME'));
            $footer = "Atas Perhatianya" . $this->WA_FORMAT_LINE_BREAK . $this->formattingItalicWhatsapp("Terima Kasih");
            return $header .
                $this->WA_FORMAT_LINE_BREAK .
                $message .
                $this->generateMultipleLineWhatsapp(3) .
                $footer;
        }

        private function formattingBoldWhatsapp($string)
        {
            return $this->WA_FORMAT_BOLD . $string . $this->WA_FORMAT_BOLD;
        }

        private function formattingItalicWhatsapp($string)
        {
            return $this->WA_FORMAT_ITALIC . $string . $this->WA_FORMAT_ITALIC;
        }

        private function sendWhatsapp($message, $to_number)
        {
            try {
                // Pastikan phone menggunakan kode negara atau
                // 62 di depannya untuk Indonesia atau
                // bisa menggunakan 0 jika nomor tujuan Indonesia

                $token = getenv('WA_PROVIDER_TOKEN');
                $phone = $to_number;
                $content = $this->formatingMessageWhatsapp($message);
                $url = getenv('WA_PROVIDER_URL') . '/send-message';
                $data =[
                    'phone' => $phone,
                    'message' => $content,
                ];
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: $token",
                    )
                );
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                $response = curl_exec($curl);
                $response = !$response ? [] : json_decode($response);
                curl_close($curl);
                if ($response->status) {
                    return [
                        'status' => 1,
                        'message' => "Success"
                    ];
                } else {
                    return [
                        'status' => 0,
                        'message' => "Failed. " . $response['message']
                    ];
                }

            } catch (\Exception $e) {
                return [
                    'status' => 0,
                    'message' => "Failed. " . $e->getMessage()
                ];
            }

        }

        private function sendMail($message, $data)
        {

        }

        public function send($data)
        {
            return $this->sendWhatsapp($data['message'], $data['to_number']);
        }

    }
