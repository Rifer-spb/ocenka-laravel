import {Button} from "@/components/ui/button";
import {IInviteTab} from "@/components/app/manager/legal/inviteTabs/types";

type Props = {
    id: number;
    currentTab: IInviteTab;
    handleReSend: Function;
    handleCancel: Function;
    handleConfirm: Function;
    handleClose: Function;
}

export default function ({ id, currentTab, handleReSend, handleCancel, handleConfirm, handleClose } : Props) {
    return (
        <>
            <div className="btn-group">
                {currentTab.id == 'inbox' ? (
                    <>
                        <Button
                            type="button"
                            className="btn btn-primary"
                            onClick={() => handleCancel(id)}
                        >Отклонить</Button>
                        <Button
                            type="button"
                            className="btn btn-success"
                            onClick={() => handleConfirm(id)}
                        >Подтвердить</Button>
                    </>
                ) : currentTab.id == 'outbox' ? (
                    <>
                        <Button
                            type="button"
                            className="btn btn-success"
                            onClick={() => handleReSend(id)}
                        >Повторить</Button>
                        <Button
                            type="button"
                            className="btn btn-primary"
                            onClick={() => handleCancel(id)}
                        >Отозвать</Button>
                    </>
                ) : currentTab.id == 'active' ? (
                    <>
                        <Button
                            type="button"
                            className="btn btn-danger"
                            onClick={() => handleClose(id)}
                        >Завершить</Button>
                    </>
                ) : ''}
            </div>
        </>
    );
}
