<?php

namespace WeDevBr\Celcoin\Tests\Integration\PIX\Participants;

use Closure;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinPIXParticipants;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class PixParticipantsListTest extends TestCase
{

    /**
     * @param int $status
     *
     * @return PromiseInterface
     */
    static private function stubGenericError(int $status): PromiseInterface
    {
        return Http::response(
            [
                'code' => $status,
                'description' => 'Message',
            ],
        );
    }

    /**
     * @return void
     * @throws RequestException
     */
    final public function testSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinPIXParticipants::GET_PARTICIPANTS_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $pix = new CelcoinPIXParticipants();
        $response = $pix->getParticipants();

        $this->assertCount(3, $response);
    }

    /**
     * @return PromiseInterface
     */
    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                [
                    'date' => '2022-03-23T00:00:00',
                    'type' => 'IDRT',
                    'name' => 'COOPERATIVA CENTRAL DE CRÉDITO DE MINAS GERAIS LTDA. - SICOOB CENTRAL CREDIMINAS',
                    'startOperationDatetime' => '2020-11-03T09:30:00+00:00',
                    'ispb' => '25683434',
                ],
                [
                    'date' => '2022-03-23T00:00:00',
                    'type' => 'IDRT',
                    'name' => 'COOPERATIVA DE CRÉDITO MÚTUO SERRA MAR LTDA. - UNICRED SERRA MAR',
                    'startOperationDatetime' => '2020-11-03T09:30:00+00:00',
                    'ispb' => '86803939',
                ],
                [
                    'date' => '2022-03-23T00:00:00',
                    'type' => 'IDRT',
                    'name' => 'COOPERATIVA DE CRÉDITO UNICRED CENTRO-SUL LTDA - UNICRED CENTRO-SUL',
                    'startOperationDatetime' => '2020-11-03T09:30:00+00:00',
                    'ispb' => '00075847',
                ],
            ],
            Response::HTTP_OK,
        );
    }

    /**
     * @param Closure $response
     * @param string $status
     *
     * @return void
     * @dataProvider errorDataProvider
     * @throws RequestException
     */
    final public function testErrors(Closure $response, mixed $status): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinPIXParticipants::GET_PARTICIPANTS_ENDPOINT,
                ) => $response,
            ],
        );

        $this->expectException(RequestException::class);
        try {
            $pix = new CelcoinPIXParticipants();
            $pix->getParticipants();
        } catch (RequestException $exception) {
            $this->assertEquals($status, $exception->getCode());
            throw $exception;
        }
    }

    /**
     * @return array[]
     */
    private function errorDataProvider(): array
    {
        return [
            'status·code·500' => [
                fn() => Http::response([], Response::HTTP_INTERNAL_SERVER_ERROR),
                Response::HTTP_INTERNAL_SERVER_ERROR,
            ],
        ];
    }
}
